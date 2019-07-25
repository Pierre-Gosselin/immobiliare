$ = jQuery
$('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var reference1 = button.data('title') // Extract info from data-* attributes
    var housing_id = button.data('id')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text(reference1)
    modal.find('.reference').val(reference1)
    modal.find('.id_housing').val(housing_id)
})