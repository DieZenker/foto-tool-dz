@if(Session::has('notice'))
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-custom alert-notice alert-light-@if(Session::has('notice-color')){{Session::get('notice-color')}}@else{{ 'primary' }}@endif fade show" role="alert">
                    @if(Session::has('notice-icon'))
                        <div class="alert-icon"><i class="fa fa-{{Session::get('notice-icon')}}"></i></div>
                    @endif
                    <div class="alert-text">{!!Session::get('notice')!!}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
