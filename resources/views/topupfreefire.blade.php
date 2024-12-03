@extends($theme . 'layouts.app')
@section('title', trans('Product Details'))

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Show Player Data</title>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                padding: 20px;
            }

            h1 {
                color: #333;
            }

            label {
                display: block;
                margin-bottom: 10px;
                font-weight: bold;
            }

            input,
            select {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-sizing: border-box;
            }

            button {
                background-color: #007bff;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            #resultContainer {
                margin-top: 20px;
            }
        </style>
    </head>

    <body>

        <label for="player_id">رقم الاعب:</label>
        <input type="text" id="player_id" required>

        <label for="item_id">عدد الجواهر:</label>
        <select name="item_id" id="item_id" required onchange="updatePrice()">
            <option value="1">100+10 جوهرة</option>
            <option value="2">310+31 جوهرة</option>
            <option value="3">520+52 جوهرة</option>
            <option value="4">1060+106 جوهرة</option>
            <option value="5">2180+218 جوهرة</option>
        </select>

        <label for="player_id">السعر:</label>
        <input readonly type="text" name="price" id="price" value="0.67 JOD" required>

        <button type="button" onclick="submitForm()">شحن</button>

        <div id="resultContainer"></div>

        <script>
            function updatePrice() {
                var item_id = document.getElementById("item_id").value;
                var price = "";
                switch (item_id) {
                    case "1":
                        price = "0.67 JOD";
                        break;
                    case "2":
                        price = "2 JOD";
                        break;
                    case "3":
                        price = "3.34 JOD";
                        break;
                    case "4":
                        price = "6.67 JOD";
                        break;
                    case "5":
                        price = "13.35 JOD";
                        break;
                    default:
                        price = "";
                }
                document.getElementById("price").value = price;
            }
        </script>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
            function submitForm() {
                if (confirm('هل أنت متأكد من رغبتك في الشحن؟')) {

                    var playerId = $('#player_id').val();
                    var itemId = $('#item_id').val();

                    // Create an object with the data
                    var requestData = {
                        player_id: playerId,
                        item_id: itemId,
                        _token: '{{ csrf_token() }}' // Include CSRF token if needed
                    };

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('showPlayerData') }}',
                        data: requestData,
                        success: function(data) {
                            // Check the status in the API response
                            if (data.status && data.status === 'success') {
                                alert('تمت العملية بنجاح. اسم اللاعب: ' + data.player_name);
                                $('#player_id').val('');

                            } else {
                                // Handle error
                                alert('حدث خطأ: ' + data.status + ', الرمز: ' + data.statusCode);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            try {
                                var errorResponse = JSON.parse(xhr.responseText);
                                if (errorResponse && errorResponse.error && errorResponse.error.code) {
                                    if (errorResponse.error.code == 'INSUFFICIENT_BALANCE') {
                                        alert('متأسفين غير متوفر رصيد حاليا');
                                    } else if (errorResponse.error.code == 'INVALIDE_PLAYER_ID') {
                                        alert('رقم الاعب غير صحيح');
                                    } else {
                                        alert(errorResponse.error.code);
                                    }
                                } else {
                                    alert('تأكد عدم ترك أي حقل فارغ أو ليس لديك رصيد');
                                }
                            } catch (e) {
                                alert('Error: Unable to parse error response');
                            }
                        }
                    });
                }
            }
        </script>


    </body>

    </html>

@endsection
