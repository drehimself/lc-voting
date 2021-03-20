$('.delete-row').on('click',function(){
    var url = $(this).data('url');
    var method = $(this).data('method');

    $(`<form action="${url}" method="post">
        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
        <input type="hidden" name="_method" value="${method}">
        </form>`).appendTo('body').submit();
});