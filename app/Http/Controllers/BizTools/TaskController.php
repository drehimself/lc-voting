<?php

namespace App\Http\Controllers\BizTools;

use App\Models\BizTools\Task;
use App\Models\BizTools\TaskBoard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        $taskBoards = TaskBoard::with(['tasks' => function ($query) {
            return $query->orderBy('sort_order');
        }])->get();
        $classes = ['error', 'info', 'warning', 'success'];

        return view('biz_tools.backend..tasks.index', compact('tasks', 'taskBoards', 'classes'));
    }

    /**
     * Send Data to datatables
     *
     */
    public function fetchData(Request $request)
    {
        $columns = [
            0 => 'subject',
            1 => 'board_id',
            2 => 'status',
            3 => 'due_date',
            4 => 'created_at',
        ];

        $totalData = Task::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')) && empty($request->input('searchName')) && empty($request->input('searchCost'))) {
            $tasks = Task::offset($start)
                ->with('board')
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $searchName = $request->input('searchName') ?? '';
            $websiteLink = $request->input('websiteLink') ?? '';

            $tasks = Task::where('subject', 'LIKE', "%{$searchName}%")
            ->where('due_date', 'LIKE', "%{$websiteLink}%")
            ->with('board')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

            $totalFiltered = Task::where('name', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$searchName}%")
            ->orWhere('due_date', '=', "{$websiteLink}")
            ->count();
        }

        $data = [];
        if (!empty($tasks)) {
            foreach ($tasks as $task) {
                $nestedData['subject'] = $task->subject;
                $nestedData['board_id'] = $task->board->name;
                $nestedData['status'] = status($task->status);
                $nestedData['due_date'] = $task->due_date->format('m/d/Y');
                $nestedData['action'] = "&emsp;<a href='javascript:;' title='destroy' class='btn btn-danger add-delete-task' data-id='{$task->id}'>Delete</a>
                          &emsp;<a href='javascript:;' title='EDIT' class='btn btn-info editLeadFromList'  data-eid='{$task->id}'>Edit</a>";
                $data[] = $nestedData;
            }
        }

        $json_data = [
            'draw'            => intval($request->input('draw')),
            'recordsTotal'    => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data'            => $data,
        ];

        echo json_encode($json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->action == null && $request->action != 'update') {
            $task = Task::create([
                'subject'  => $request->task_subject,
                'board_id' => $request->task_board,
                'status'   => $request->task_status,
                'due_date' => $request->due_date,
            ]);

            if ($task) {
                return back()->with('success', 'Task Added Successfully');
            }
        } else {
            $task = Task::findOrFail($request->taskID);

            $task->subject = $request->task_subject;
            $task->board_id = $request->task_board;
            $task->status = $request->task_status;
            $task->due_date = $request->due_date;

            if ($task->update()) {
                return back()->with('success', 'Task Updated Successfully');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($task)
    {
        $task = Task::where('id', $task)->first();

        if ($task) {
            return response()->json(['status' => true, 'data' => $task]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if ($task->delete()) {
            return back()->with('success', 'Task Deleted Successfully');
        }
    }

    /**
     * Update Lead Board When Dragged
     *
     */
    public function updateBoard(Request $request)
    {
        $task = Task::where('id', $request->task_id)->first();

        if ($task) {
            $task->board_id = $request->new_board;
            $task->sort_order = $request->sort;

            $task->update();

            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
}
