<div>
    <div class="modal fade" id="modal-form" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">{{$title}}</h4>
            </div>
                {{$slot}}
          </div>
        </div>
    </div>
</div>