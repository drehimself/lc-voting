<div class="card mb-4">
   <div class="card-header">
       <i class="fas fa-table mr-1"></i>
       Ledger
   </div>

   <div class="card-body">
      <div class="table-responsive" id="LedgerTable">
         <table class="table table-striped" id="LedgerTableDT">
            <thead class="">
               <tr>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Category</th> 
                  <th>Type</th>
                  <th>Amount</th>
                  <th width="15%">Action</th>
               </tr>
            </thead>
            <tbody>
               @forelse ($ledgers as $ledger)
               <td>{{ isset($ledger->date) ? Carbon\Carbon::parse($ledger->date)->format('m/d/Y')  : ''}}</td>
               <td style="font-size:14px;">{{ $ledger->description }}</td>
               <td>{{ $ledger->ledgerCategory->name }}</td>
               <td>{{ $ledger->type }}</td>
               <td>
                  @if($ledger->type == 'expense')
                  <span class="badge badge-danger" style="font-size:14px;">{{ abs($ledger->amount) }}</span>
                  @else
                  <span class="badge badge-danger" style="font-size:14px;">{{ $ledger->amount }}</span>
                  @endif
               </td>
               <td>
                  <a href="javascript:;" class="btn btn-danger add-delete-ledger" data-id="{{ $ledger->id }}"><i class="fa fa-trash"></i></a>
                  <a href="javascript:;"  class="btn btn-info editLedgerFromList" data-eid="{{ $ledger->id }}"><i class="fa fa-edit"></i></a>
               </td>
               </tr>
               @empty
                     
               @endforelse
            </tbody>
         </table>
      </div>
   </div>
</div>