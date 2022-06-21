@extends('dashboard.layouts.layout')

@section('body')
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{__('words.dashboard')}}</li>
        <li class="breadcrumb-item"><a href="#">{{__('words.dashboard')}}</a>
        </li>
        <li class="breadcrumb-item active">{{__('words.categories')}}</li>

        <!-- Breadcrumb Menu-->
        <li class="breadcrumb-menu">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn btn-secondary" href="#"><i class="icon-speech"></i></a>
                <a class="btn btn-secondary" href="./"><i class="icon-graph"></i> &nbsp;{{__('words.dashboard')}}</a>
                <a class="btn btn-secondary" href="#"><i class="icon-settings"></i> &nbsp;{{__('words.categories')}}</a>
            </div>
        </li>
    </ol>


    {{-- {{dd($setting)}} --}}

    <div class="container-fluid">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Striped Table
                </div>
                <div class="card-block">
                    <table class="table table-striped" id="table_id">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Parent</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>



    {{-- delete --}}
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <form action="{{ Route('dashboard.posts.delete') }}" method="POST">
        <div class="modal-content">

            <div class="modal-body">
                @csrf

                <div class="form-group">
                    <p>{{ __('words.sure delete') }}</p>
                    @csrf
                    <input type="hidden" name="id" id="id">
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">{{ __('words.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ __('words.delete') }} </button>
            </div>
        </div>
    </form>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
{{-- delete --}}
@endsection







@push('javascripts')
    <script type="text/javascript">
        $(function() {
            var table = $('#table_id').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ Route('dashboard.posts.all') }}",
                columns: [
                 
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                    }
                ]
            });

        });

        $('#table_id tbody').on('click', '#deleteBtn', function(argument) {
            var id = $(this).attr("data-id");
            console.log(id);
            $('#deletemodal #id').val(id);
        })
    </script>
@endpush
