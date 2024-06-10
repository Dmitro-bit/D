/*пошук*/
    
    $(document).ready(function(){
        $('#search').on('input', function(){
            var query = $(this).val();
            if(query !== ''){
                $.ajax({
                    url: '../Пошук/search.php',
                    method: 'POST',
                    data: {search: query},
                    success: function(data){
                        $('.search-results').html(data);
                    }
                });
            } else {
                $('.search-results').html('');
            }
        });
    });
/*пошук*/



/*авторізація шукач*/

    function openAuthWindow(action) {
        if (action === 'login') {
            link = "../Шукач/login_user1.html";
        } else if (action === 'register') {
            link = "../Шукач/zar_user.html";
        }
        window.location.href = link;
    }

    document.getElementById('loginButton').addEventListener('click', function() {
        openAuthWindow('login');
    });

    document.getElementById('registerButton').addEventListener('click', function() {
        openAuthWindow('register');
    });
/*авторізація шукач*/



/*авторізація шукач*/




/*авторізація шукач*/
