<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
</head>
<body>
    <section class="container">
        <div>
            @include('admin.component.slidebar')
        </div>
        <div class="product-categories">
            <div class="category">
                <img src="https://via.placeholder.com/300" alt="Danh mục 1">
                <div class="overlay">
                    <h3>User</h3>
                </div>
                <div class="product-quantity">
                    <p>Quantity: {{ $user_quantity }}</p>
                </div>
            </div>
            <div class="category">
                <img src="https://via.placeholder.com/300" alt="Danh mục 2">
                <div class="overlay">
                    <h3>Category</h3>
                </div>
                <div class="product-quantity">
                    <p>Quantity: {{ $category_quantity }}</p>
                </div>
            </div>
            <div class="category">
                <img src="https://via.placeholder.com/300" alt="Danh mục 3">
                <div class="overlay">
                    <h3>Book</h3>
                </div>
                <div class="product-quantity">
                    <p>Quantity: {{ $book_quantity }}</p>
                </div>
            </div>
            <div class="category">
                <img src="https://via.placeholder.com/300" alt="Danh mục 3">
                <div class="overlay">
                    <h3>Order</h3>
                </div>
                <div class="product-quantity">
                    <p>Quantity: {{ $order_quantity }}</p>
                </div>
            </div>
            <div class="category">
                <img src="https://via.placeholder.com/300" alt="Danh mục 3">
                <div class="overlay">
                    <h3>Voucher</h3>
                </div>
                <div class="product-quantity">
                    <p>Quantity: 0</p>
                </div>
            </div>
        </div>
        <div class="charts">
            <h3 class="text-primary text-center">Charts</h3>
            <div class="row">
                <!-- Area Chart -->
                <div class="col-sm-6 text-center chart-custom">
                    <label class="label label-success">Doanh thu</label><br>
                    <select id="chart1" style="padding: 5px; margin: 10px; float: left;">
                        <option value="">Select year</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <!-- Thêm các năm khác nếu cần -->
                    </select>
                    <canvas id="revenue-chart" width="400" height="200"></canvas>
                </div>
                <!-- Line Chart -->
                <div class="col-sm-6 text-center chart-custom">
                    <label class="label label-success">Số sản phẩm bán ra</label><br>
                    <select id="chart2" style="padding: 5px; margin: 10px; float: left;">
                        <option value="">Select year</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <!-- Thêm các năm khác nếu cần -->
                    </select>
                    <canvas id="soldQuantity-chart" width="400" height="200"></canvas>
                </div>
                <!-- Order Chart -->
                <div class="col-sm-6 text-center chart-custom">
                    <label class="label label-success">Số sản phẩm bán ra</label><br>
                    <select style="padding: 5px; margin: 10px; float: left;">
                        <option value="">Select year</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <!-- Thêm các năm khác nếu cần -->
                    </select>
                    <canvas id="order-chart" width="30" height="200"></canvas>
                </div>

            </div>
        </div>
        <br>
    </section>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        var revenueChart;
        var soldQuantityChart;
        var orderChart;

        function drawChart(nameChart, data, id_tag,unit,title) {
            const ctx = $('#' + id_tag)[0].getContext('2d');
            if (nameChart) {
                nameChart.destroy();
            }
            nameChart = new Chart(ctx, {
                type: 'bar'
                , data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'
                        , 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                    ]
                    , datasets: [{
                        label: title + ' ('+ unit +')'
                        , data: data
                        , borderColor: 'rgba(75, 192, 192, 1)'
                        , backgroundColor: 'rgba(75, 192, 192, 0.2)'
                        , borderWidth: 1
                    }]
                }
                , options: {
                    responsive: true
                    , scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                    , plugins: {
                        tooltip: {
                            enabled: true
                        }
                        , datalabels: {
                            anchor: 'end'
                            , align: 'end'
                            , formatter: (value) => {
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            }
                            , color: 'black'
                        }
                    }
                }
                , plugins: [ChartDataLabels] // Đừng quên thêm plugin ChartDataLabels
            });
            return nameChart;
        }

        function orderChart(data) {
            const ctx = $('#order-chart')[0].getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'pie', // Loại biểu đồ cột ngang
                data: {
                    labels: ['Đã đặt', 'Đã hoàn thành', 'Đã hủy', 'Đã trả hàng']
                    , datasets: [{
                        label: 'Số lượng'
                        , data: data, // Dữ liệu tương ứng với các nhãn
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)'
                            , 'rgba(153, 102, 255, 0.2)'
                            , 'rgba(255, 99, 132, 0.2)'
                            , 'rgba(255, 206, 86, 0.2)'
                        ]
                        , borderColor: [
                            'rgba(75, 192, 192, 1)'
                            , 'rgba(153, 102, 255, 1)'
                            , 'rgba(255, 99, 132, 1)'
                            , 'rgba(255, 206, 86, 1)'
                        ]
                        , borderWidth: 1
                    }]
                }
                , options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const label = tooltipItem.label || '';
                                    const value = tooltipItem.raw || 0;
                                    const total = tooltipItem.dataset.data.reduce((acc, val) => acc + val, 0);
                                    const percentage = ((value / total) * 100).toFixed(2);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                            // enabled: false
                        }
                        , datalabels: {
                            display: true
                            , color: 'black'
                            , formatter: (value, context) => {
                                const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                const percentage = ((value / total) * 100).toFixed(2);
                                if (percentage == 0) {
                                    return null
                                }
                                return `${value} (${percentage}%)`;
                            }
                        }
                    }
                }
                , plugins: [ChartDataLabels]
            });
        }

        $(document).ready(function() {
            const currentYear = new Date().getFullYear();
            // Khởi tạo các promise từ các yêu cầu AJAX
            let revenueRequest = $.ajax({
                url: '/admin/revenue'
                , type: 'GET'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , 'year': currentYear
                }
            });

            let soldQuantityRequest = $.ajax({
                url: '/admin/soldQuantity'
                , type: 'GET'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , 'year': currentYear
                }
            });

            // Sử dụng $.when() để chờ cả 2 promise (yêu cầu AJAX) hoàn thành
            $.when(revenueRequest, soldQuantityRequest).done(function(revenueResponse, soldQuantityResponse) {

                // Lấy dữ liệu trả về từ các yêu cầu
                let revenueArr = revenueResponse[0].arr; // Lấy dữ liệu từ revenueRequest
                let soldQuantityArr = soldQuantityResponse[0].arr; // Lấy dữ liệu từ soldQuantityRequest

                // Vẽ biểu đồ doanh thu
                revenueChart = drawChart(revenueChart, revenueArr, 'revenue-chart','VND','Revenue');

                // Vẽ biểu đồ số lượng bán ra
                soldQuantityChart = drawChart(soldQuantityChart, soldQuantityArr, 'soldQuantity-chart','book','Quantity');

                // Sau khi cả 2 yêu cầu đều hoàn thành, thực hiện vẽ orderChart
                orderChart([10, 20, 0, 15]);
            }).fail(function(response) {
                console.log("Có lỗi xảy ra:", response);
            });

            $('#chart1').change(function() {
                const selectedValue = $(this).val();
                if (selectedValue) {
                    $.ajax({
                        url: '/admin/revenue'
                        , type: 'GET'
                        , data: {
                            _token: "{{ csrf_token() }}"
                            , 'year': selectedValue
                        }
                        , success: function(response) {
                            arr = response.arr
                            // $('#revenue-chart').empty();
                            revenueChart = drawChart(revenueChart, arr, 'revenue-chart','VND','Revenue');
                        }
                        , error: function(response) {
                            console.log(response)
                        }
                    })
                }
            });
            $('#chart2').change(function() {
                const selectedValue = $(this).val();
                if (selectedValue) {
                    $.ajax({
                        url: '/admin/soldQuantity'
                        , type: 'GET'
                        , data: {
                            _token: "{{ csrf_token() }}"
                            , 'year': selectedValue
                        }
                        , success: function(response) {
                            arr = response.arr
                            soldQuantityChart = drawChart(soldQuantityChart, arr, 'soldQuantity-chart','book','Quantity');
                        }
                        , error: function(response) {
                            console.log(response)
                        }
                    })
                }
            });

        });

    </script>
</body>
</html>
