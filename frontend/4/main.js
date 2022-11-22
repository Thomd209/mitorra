$(document).ready(function() {
    $('p').on('click', function() {
        let data_id = $(this).data('id')
        console.log(data_id)
    })
})