@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card-header d-flex align-items-center border-0">
            <h3 class="w-50 float-left card-title m-0">New Users</h3>

        </div>
        <div class="row" style="margin-left:70px;">
            <div class="col-md-3">
                <input type="text" id="filterName" class="form-control" placeholder="Nom">
            </div>
            <div class="col-md-3">
                <input type="text" id="filterEmail" class="form-control" placeholder="Email">
            </div>
            <div class="col-md-3">
                <select id="filterStatus" class="form-control">
                    <option value="">Tous les statuts</option>
                    <option value="Nouveau">Nouveau</option>
                    <option value="Récent">Récent</option>
                    <option value="Ancien">Ancien</option>
                </select>
            </div>
            <div class="col-md-3" id="applyFilter">
                <div id="searchIcon" class="search-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div >
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Sign up</th>
                                <th>Status</th>
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
    <div class="row">
        <div class="col">
            <div id="summaryCharts" class="d-flex justify-content-between" style="margin-right: 0;">
                <canvas id="statusChart" width="300" height="300"></canvas>
            </div>
        </div>
      @include('includes.modal')


@endsection
