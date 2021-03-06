@extends('layouts.sidemenu')

@section('main')
    <div data-animation="fadeInUp">
        @if(session('message'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                <i class="fa fa-check-circle"></i> {{ session()->pull('message') }}
            </div>
        @endif
        <div class="heading heading-center m-b-40">
            <h2>Group Requests Received</h2>
            <div class="separator">
                <span>You can manage all your group requests received here</span>
            </div>
        </div>
        <div class="col-md-12">
            @if (count($requests) > 0)
                <div class="row col-no-margin equalize" data-equalize-item=".text-box">
                    <?php $colors = array("#506681","#41566f","#32475f")?>
                    @foreach($requests as $key => $request)
                        @if($key >= 3 && $key%3 == 0)
                            <div class="space"></div>
                        @endif
                        <div class="col-md-4" style="background-color: {{$colors[$key%3]}}">
                            <div class="text-box hover-effect" data-target="#requestDetails" data-id="{{$request->requestid}}" data-toggle="modal">
                                <a>
                                    <i class="fa fa-users"></i>
                                    <h3>{{$request->groupname}}</h3>
                                    <p>Click on the box to view group request details</p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal fade" id="requestDetails" tabindex="-1" role="modal" aria-labelledby="modal-label" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        </div>
                    </div>
                </div>
                <?php echo $requests->render(); ?>
            @else
                <div class="text-center">
                    <i class="fa fa-ban fa-5x"></i>
                    <h5>No results to display</h5>
                </div>
            @endif
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.text-box').on('click', function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: "GET",
                    url: "./requestdetails",
                    data: {
                        requestid: $(this).data('id')
                    },
                    beforeSend: function () {
                        $('.modal-content').html('');
                        $.LoadingOverlay('show');
                    },
                    success: function(data) {
                        $.LoadingOverlay('hide',true);
                        $('.modal-content').html(data);
                    },
                    error: function (xhr, status) {
                        console.log(status);
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection