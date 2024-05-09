
function toggleTheme() {

    const body = document.body;
    const themeIcon = document.getElementById('themeIcon');

    body.classList.toggle('dark-theme');

    if (body.classList.contains('dark-theme')) {
        themeIcon.name = 'moon-outline';
    } else {
        themeIcon.name = 'sunny-outline';
    }
}


    let list = document.querySelectorAll(".navigation li");
    //console.log("Navigation sélectionnée :", navigation);


    list.forEach((item) => item.addEventListener("mouseover", activeLink));

    function activeLink() {
        console.log("Mouse over on navigation item");
        list.forEach((item) => {
            item.classList.remove("hovered");
        });
        this.classList.add("hovered");
    }

    let toggle = document.querySelector(".toggle");
    let navigation = document.querySelector(".navigation");
    let main = document.querySelector(".main");


    toggle.onclick = function () {
        console.log("Toggle button clicked");
        navigation.classList.toggle("active");
        main.classList.toggle("active");
    };

document.addEventListener('DOMContentLoaded', function () {

    const spinner = document.getElementById("spinner");
    spinner.style.display = "block";
    var ctx = document.getElementById('myChart').getContext('2d');


    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Users',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: false, // Empêche le graphique de s'adapter à la taille du conteneur
            maintainAspectRatio: false, // Empêche le graphique de conserver son aspect ratio
            width: 800,
            height: 150
        }
    });


    const pourcentageReponsesTrouvees = {
        trouvees: 70,
        nonTrouvees: 30
    };


    var ctxpie = document.getElementById('pieChart').getContext('2d');


    var pieChart = new Chart(ctxpie, {
        type: 'pie',
        data: {
            labels: ['Réponses Trouvées', 'Réponses Non Trouvées'],
            datasets: [{
                label: 'Pourcentage de Réponses Trouvées',
                data: [pourcentageReponsesTrouvees.trouvees, pourcentageReponsesTrouvees.nonTrouvees],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 99, 132, 0.5)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Pourcentage de Réponses Trouvées dans le Chat de Support'
            }
        }
    });


    let list = document.querySelectorAll(".navigation li");
    //console.log("Navigation sélectionnée :", navigation);
    function activeLink() {
        list.forEach((item) => {
            item.classList.remove("hovered");
        });
        this.classList.add("hovered");
    }


    list.forEach((item) => item.addEventListener("mouseover", activeLink));


    let toggle = document.querySelector(".toggle");
    let navigation = document.querySelector(".navigation");
    let main = document.querySelector(".main");


    toggle.onclick = function () {
        navigation.classList.toggle("active");
        main.classList.toggle("active");
    };

});
window.addEventListener("load", function () {
    spinner.style.display = "none";
    console.log('hello');
});
function fetchusers() {
    $.ajax({
        type: "GET",
        url: "/fetch-users",
        dataType: "json",
        success: function(response) {
            $('tbody').empty();
            $.each(response.users, function(key, item) {
                console.log("Date d'inscription de l'utilisateur " + item.name + " : " + item.created_at);
                let statusButton;
                const today = new Date();
                const signUpDate = new Date(item.created_at);
                const differenceInDays = Math.floor((today - signUpDate) / (1000 * 60 * 60 * 24));

                if (differenceInDays <= 7) {
                    statusButton = '<button type="button" class="btn btn-success btn-rounded m-1">Nouveau</button>';
                } else if (differenceInDays <= 14) {
                    statusButton = '<button type="button" class="btn btn-primary btn-rounded m-1">Récent</button>';
                } else {
                    statusButton = '<button type="button" class="btn btn-primary btn-rounded m-1">Ancien</button>';
                }
                $('tbody').append(
                    '<tr class="loubna">\
                        <td>' + item.id + '</td>\
                        <td>' + item.name + '</td>\
                        <td>' + item.email + '</td>\
                        <td>' + item.created_at + '</td>\
                        <td>' + statusButton + '</td>\
                      <td> <div class="delete-icon" data-id="' + item.id + '"><ion-icon name="close-circle-outline"></ion-icon></div></td>\
                    </tr>'
                );
            });
        }
    });
}

$(document).ready(function() {
    fetchusers();
});
$(document).on('click', '.delete-icon', function(e) {
    e.preventDefault();
    var users_id = $(this).data('id');

    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Vous ne pourrez pas revenir en arrière après cela !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, supprimer!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: "/delete-user/" + users_id,
                success: function(response) {
                    Swal.fire(
                        'Supprimé!',
                        'L\'utilisateur a été supprimé avec succès.',
                        'success'
                    );
                    fetchusers();
                    console.log("Fetching users...");
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);

                    Swal.fire(
                        'Erreur!',
                        'Une erreur s\'est produite lors de la suppression de l\'utilisateur.',
                        'error'
                    );
                }
            });
        }
    });
});
$(document).on('click', '.loubna', function() {

    var userId = $(this).find('td:eq(0)').text();
    var userName = $(this).find('td:eq(1)').text();
    var userEmail = $(this).find('td:eq(2)').text();
    var userCreatedAt = $(this).find('td:eq(3)').text();
    var userStatus = $(this).find('td:eq(4)').text();
    var statusButton = $(this).find('td:eq(4)').find('button').text();

    function loadModalContent() {
        $.ajax({
            url:"/infos/user/modal/" + userId,
            method: 'GET',
            data: { userStatus: statusButton },
            success: function(response) {
                $('#userInfoModal .modal-body').html(response.modalContent);
                $('#userInfoModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
    loadModalContent();

});
$(document).on('click', '#applyFilter', function() {
    var name = $('#filterName').val();
    var email = $('#filterEmail').val();
    var status = $('#filterStatus').val();

    $.ajax({
        type: 'GET',
        url: '{{ route("filter.users") }}',
        data: {
            name: name,
            email: email,
            status: status
        },
        success: function(response) {
            updateUsersTable(response.users);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const statusData = {
        labels: ['Nouveau', 'Récent', 'Ancien'],
        datasets: [{
            label: 'Nombre d\'utilisateurs',
            data: [20, 30, 10],
            backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 206, 86, 0.2)'],
            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)'],
            borderWidth: 1
        }]
    };


    const statusChartConfig = {
        type: 'bar',
        data: statusData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true, //emplille les bar  horizontalement (x) et verticalement (y)
                },
                y: {
                    stacked: true,
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Nombre d\'utilisateurs par statut'
                }
            }
        }
    };

    const statusChartCanvas = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusChartCanvas, statusChartConfig);
});

document.querySelectorAll('.loubna').forEach(item => {
    item.addEventListener('mouseover', () => {
        console.log('Hover effect triggered!');
        // Ajoutez ici le code pour appliquer le style de hover si nécessaire
    });
});
