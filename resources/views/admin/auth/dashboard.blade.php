<<<<<<< HEAD
<h2>admin dashboard
</h2>
=======
@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div >
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
         <!-- ======================= Cards ================== -->
        <div class="cardBox">
            <div class="card">
                <div>
                    <div class="numbers">120</div>
                    <div class="cardName">Users</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="person-add-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">6</div>
                    <div class="cardName">experts</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="medal-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">100</div>
                    <div class="cardName">Rating</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="chatbubbles-outline"></ion-icon>
                </div>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="myChart" width="900" height="400"></canvas>
            <div class="pie-chart">
            <canvas id="pieChart" width="300" height="200"></canvas>
            </div>
        </div>

    </div>

@endsection
>>>>>>> 63bcfbe8ac249ae523a11dfcf71fc94214d22a52
