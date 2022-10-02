@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card container-fluid overflow-hidden">
                <div class="card-header row justify-content-between gx-5">
                            <h6 class=" col align-self-start">Add Courier</h6>
                            <select id="billsselect" onchange="loadCourierData(this.value)" class=" form-select col align-self-end wr"></select>
                </div>

                <div class="card-body">

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="courierIdEntered" placeholder="Enter Courier Id" aria-label="Enter Courier Id" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" onclick="addcourier(document.getElementById('billsselect').value,document.getElementById('courierIdEntered').value)" type="button" id="button-addon2">Add</button>
                      </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container p-1 mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card container-fluid overflow-hidden">
                    <div class="card-header row justify-content-between gx-5">
                                <h6 class=" col align-self-start" id="billtitle"></h6>
                    </div>

                    <div class="card-body">
                        {{-- <table-component></table-component> --}}
                        <table id="courierdatatable" class=" table"></table>
                    </div>
                </div>
            </div>

        </div>
</div>



@endsection
