  <div class="modal fade" id="modal_xl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

      </div>
    </div>
  </div>

  <script type="text/javascript">
  $(document).ready(function(){
    $('#modal_xl').on('shown.bs.modal',function(event){
      var _obj_button = $(event.relatedTarget);
      var _href       = _obj_button.data('href');

      $('#modal_xl .modal-content').load(_href);
    }).on('hidden.bs.modal', function(){
      $('#modal_xl .modal-content').empty();
    });
  });
  </script>
