<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kedai Akbar') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="app sidebar-mini">
    <header class="app-header"><a class="app-header__logo" href="{{ url('/') }}">{{ config('app.name', 'Cafe') }}</a>
        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>

        <ul class="app-nav">
            <li class="app-search">
            <input class="app-search__input" type="search" placeholder="Search">
            <button class="app-search__button"><i class="fa fa-search"></i></button>
            </li>
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications"><i class="fa fa-bell-o fa-lg"></i></a>
                <ul class="app-notification dropdown-menu dropdown-menu-right">
                    <li class="app-notification__title">Ada 5 Pesan yang Belum Dibaca.</li>
                    <div class="app-notification__content">
                        @for($i=0;$i < 5; $i++)
                        <li>
                            <a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                                <div>
                                    <p class="app-notification__message">Admin Mengirim Pesan</p>
                                    <p class="app-notification__meta">2 min ago</p>
                                </div>
                            </a>
                        </li>
                        @endfor
                    </div>
                    <li class="app-notification__footer"><a href="#">Lihat Semua Notifikasi.</a></li>
                </ul>
            </li>
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="{{ url('/settings') }}"><i class="fa fa-cog fa-lg"></i> Pengaturan</a></li>
                    <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="fa fa-user fa-lg"></i> Profil</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-lg"></i> {{ __('Logout') }}</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></li>
                </ul>
            </li>
        </ul>
    </header>
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" width="50" src="{{ asset('images/profile/' . Auth::user()->photo) }}" alt="User Image">
            <div>
                <p class="app-sidebar__user-name">{{ Auth::user()->first_name }}</p>
                <p class="app-sidebar__user-designation">Admin</p>
            </div>
        </div>
        <ul class="app-menu">
            <li><a class="app-menu__item {{ $title == 'Home' ? 'active' : '' }}" href="{{ url('/home') }}"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Home</span></a></li>
            <li><a class="app-menu__item {{ $title == 'Laporan' ? 'active' : '' }}" href="{{ url('/report') }}"><i class="app-menu__icon fa fa-paperclip"></i><span class="app-menu__label">Laporan</span></a></li>
            <li><a class="app-menu__item {{ ($title == 'Produk' || $title == 'Kategori') ? 'active' : '' }}" href="{{ url('/product') }}"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Produk</span></a></li>
            <li class="treeview {{ ($title == 'Kartu Stok' || $title == 'Stok Masuk' || $title == 'Stok Keluar' || $title == 'Stok Transfer' || $title == 'Stok Opname') ? 'is-expanded' : '' }}"><a class="app-menu__item" href="{{ url('/inventory') }}" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Inventori</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item  {{ ($title == 'Kartu Stok') ? 'active' : '' }}" href="{{ url('/stock/card') }}"><i class="icon fa fa-circle-o"></i> Kartu Stok</a></li>
                    <li><a class="treeview-item  {{ ($title == 'Stok Masuk') ? 'active' : '' }}" href="{{ url('/stock/in') }}"><i class="icon fa fa-circle-o"></i> Stok Masuk</a></li>
                    <li><a class="treeview-item  {{ ($title == 'Stok Keluar') ? 'active' : '' }}" href="{{ url('/stock/out') }}"><i class="icon fa fa-circle-o"></i> Stok Keluar</a></li>
                    <li><a class="treeview-item  {{ ($title == 'Stok Transfer') ? 'active' : '' }}" href="{{ url('/stock/transfer') }}"><i class="icon fa fa-circle-o"></i> Transfer Stok</a></li>
                    <li><a class="treeview-item  {{ ($title == 'Stok Opname') ? 'active' : '' }}" href="{{ url('/stock/opname') }}"><i class="icon fa fa-circle-o"></i> Stok Opname</a></li>
                </ul>
            </li>
            <li class="treeview {{ ($title == 'Supplier' || $title == 'Bahan Mentah' || $title == 'Purchase Order' || $title == 'Daftar Belanja') ? 'is-expanded' : '' }}"><a class="app-menu__item" href="{{ url('/purchase') }}" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">Pembelian</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item {{ ($title == 'Supplier') ? 'active' : '' }}" href="{{ url('/supplier') }}"><i class="icon fa fa-truck"></i> Supplier</a></li>
                    <li><a class="treeview-item {{ ($title == 'Bahan Mentah') ? 'active' : '' }}" href="{{ url('/material') }}"><i class="icon fa fa-cubes"></i> Bahan Mentah</a></li>
                    <li><a class="treeview-item {{ ($title == 'Purchase Order') ? 'active' : '' }}" href="{{ url('/purchase') }}"><i class="icon fa fa-shopping-basket"></i> Purchase Order</a></li>
                    <li><a class="treeview-item {{ ($title == 'Daftar Belanja') ? 'active' : '' }}" href="{{ url('/purchase/list') }}"><i class="icon fa fa-shopping-cart"></i> Daftar Belanja</a></li>
                </ul>
            </li>
            <li class="treeview {{ ($title == 'Outlet' || $title == 'Pelanggan' || $title == 'Karyawan' || $title == 'Promo' || $title == 'Pajak & Services' || $title == 'Perangkat') ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Bisnis</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item {{ ($title == 'Outlet') ? 'active' : '' }}" href="{{ url('/outlet') }}"><i class="icon fa fa-building"></i> Outlet</a></li>
                    <li><a class="treeview-item {{ ($title == 'Pajak & Services') ? 'active' : '' }}" href="{{ url('/tax') }}"><i class="icon fa fa-dollar"></i> Pajak & Services</a></li>
                    <li><a class="treeview-item {{ ($title == 'Pelanggan') ? 'active' : '' }}" href="{{ url('/customer') }}"><i class="icon fa fa-users"></i> Pelanggan</a></li>
                    <li><a class="treeview-item {{ ($title == 'Perangkat') ? 'active' : '' }}" href="{{ url('/devices') }}"><i class="icon fa fa-desktop"></i> Perangkat</a></li>
                    <li><a class="treeview-item {{ ($title == 'Karyawan') ? 'active' : '' }}" href="{{ url('/employees') }}"><i class="icon fa fa-male"></i> Karyawan</a></li>
                    <li><a class="treeview-item {{ ($title == 'Promo') ? 'active' : '' }}" href="{{ url('/promo') }}"><i class="icon fa fa-percent"></i> Promo</a></li>
                </ul>
            </li>
        </ul>
    </aside>
    <main class="app-content">
        @yield('content')
    </main>
    <script src="{{ asset('js/app.js') }}"></script>
    @if($title == 'Home' || $title == 'Outlet')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDslWxu2Q7pwlnT_DEnwJRc9qwHJ8apFhE&callback=initMap" type="text/javascript"></script>
    @endif
    @if($title == 'Home')
    <script>
        var customLabel = {
            Cafe: {
                label: 'C'
            }
        };

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                center: new google.maps.LatLng(-6.3080942, 106.827183),
                zoom: 12
            });
            var infoWindow = new google.maps.InfoWindow;

            // Change this depending on the name of your PHP or XML file
            $.ajax({
                url: document.location.origin + '/outlet/maps',
                data: {},
                dataType: 'json',
                method: 'get',
                success: function(data) {
                    var markers = data.data;

                    Array.prototype.forEach.call(markers, function(markerElem) {
                        var id = markerElem.id;
                        var name = markerElem.name;
                        var address = markerElem.address;
                        var type = 'Cafe';
                        var point = new google.maps.LatLng(
                            parseFloat(markerElem.lat),
                            parseFloat(markerElem.lng));

                        var infowincontent = document.createElement('div');
                        var strong = document.createElement('strong');
                        strong.textContent = name
                        infowincontent.appendChild(strong);
                        infowincontent.appendChild(document.createElement('br'));

                        var text = document.createElement('text');
                        text.textContent = address
                        infowincontent.appendChild(text);
                        var icon = customLabel[type] || {};
                        var marker = new google.maps.Marker({
                            map: map,
                            position: point,
                            label: icon.label
                        });
                        marker.addListener('click', function() {
                            infoWindow.setContent(infowincontent);
                            infoWindow.open(map, marker);
                        });
                    });
                }
            })

        }
    </script>
    @endif
    <script>
        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }
        </script>
    @if($title == 'Kartu Stok')
    <script>
        $(document).ready(function(){
            $('#stock-table').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                }
            });
        });
    </script>
    @endif
    @if($title == 'Stok Masuk')
    <script>
        $(document).ready(function() {
            let variation = [], str = '', count = 1, i = 0, selected = [], temp = [];
            $('#stock-table').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                },
                "order": [[ 2, "desc" ]]
            });
            if (document.location.pathname.split('/').pop() == 'create') {
                $(document).on('change', '.product-stock', function(e){
                    if ((jQuery.isEmptyObject(selected))){
                        selected.push({ id: $(this).data('id'), val: $(this).val()});
                        $(this).attr('readonly', '')
                    } else {
                        if(selected.find( ({val}) => val == $(this).val() ) == undefined) {
                            if(selected.find(e => e.id == $(this).data('id'))){
                                temp = selected.filter(e => e.id != $(this).data('id'));
                                selected = temp;
                                selected.push({ id: $(this).data('id'), val: $(this).val()})
                                $(this).attr('readonly', '')
                            } else {
                                selected.push({ id: $(this).data('id'), val: $(this).val()})
                                $(this).attr('readonly', '')
                            }
                        } else {
                            ($(this).parent().parent().remove('tr'));count -= 1;
                            temp = selected.filter(e => e.id != $(this).data('id'));
                            selected = temp;let total = 0;
                            alert('Produk sudah dipilih di baris lain!')
                            $('input.totalPrice').each(function(i, item) {
                                total += parseInt($(this).val());
                            })
                            $('#grand-total > span').html(addCommas(total));
                        }
                    }
                });
                $('#stock-addTable').click(function(e){
                    e.preventDefault();
                    if ($('#stock-create-table').children('tbody').children().length == variation.length){
                        alert("Kamu melebihi Baris yang diperkenankan!");
                    } else {
                        str = '<tr data-id="'+ count +'"><td><select class="product-stock form-control" data-id="'+ count +'" name="product[]"><option value="0">Pilih Produk</option>';
                        $.each(variation, function(i, item) {
                            str += '<option value="'+ item.product_variation_id +'">'+ item.title +'</option>';
                        });
                        str+= '</select></td><td class="quantity"><input type="number" data-id="'+ count +'" min="0" name="quantity[]" value="0" readonly class="form-control quantity"></td><td class="satuan"><p class="satuan" data-id="'+ count +'">Satuan</p></td><td class="pricePerUnit"><input type="text" class="form-control pricePerUnit" readonly value="0" data-id="'+ count +'" name="pricePerUnit[]"></td><td class="totalPrice"><input type="text" class="form-control totalPrice" value="0" data-id="'+ count +'" readonly name="totalPrice[]"></td></tr>';
                        $('#tbody-stock').append(str);count += 1;
                    }
                });
                $('#stock-removeTable').click(function(e){
                    e.preventDefault();
                    if($('#stock-create-table').children('tbody#tbody-stock').children().length == 2) { $('.product-stock').removeAttr('readonly') }
                    if ($('#stock-create-table').children('tbody#tbody-stock').children().length == 1){
                        alert("Tidak dapat menghapus baris!")
                    } else {
                        ($('#stock-create-table').children('tbody#tbody-stock').children().last().remove());count -= 1;
                        temp = (selected.filter(e => e.id != count));
                        selected = temp;let total = 0;
                        $('input.totalPrice').each(function(i, item) {
                            total += parseInt($(this).val());
                        })
                        $('#grand-total > span').html(formatNumber(total));
                    }
                });
                $(document).on('change', '#outlet', function(e) {
                    e.preventDefault();$('#tbody-stock').children().remove();count = 0;$('.btn-option-table').css('display', 'none');$('.notify').css('display', 'inline-block');
                    if($(this).val() > 0) { $('.btn-option-table').css('display', 'inline');$('.notify').css('display', 'none');
                        $('#footer-table').css('display', 'inline-block');
                        $.ajax({
                            url: document.location.href,
                            method: 'POST',
                            dataType: 'JSON',
                            data: {
                                "_token" : $('meta[name="csrf-token"]').attr('content'),
                                "outlet": $(this).val()
                            },
                            success: function(data) {
                                if(data.status) {
                                    if(data.data.length > 0) {
                                        variation = (data.data);
                                        str = '<tr data-id="'+ count +'"><td><select class="product-stock form-control" data-id="'+1+'" name="product[]"><option value="0">Pilih Produk</option>';
                                        $.each(variation, function(i, item) {
                                            str += '<option value="'+ item.product_variation_id +'">'+ item.title +'</option>';
                                        });
                                        str+= '</select></td><td class="quantity"><input type="number" min="0" data-id="'+ count +'" name="quantity[]" readonly value="0" class="form-control quantity"></td><td class="satuan"><p class="satuan" data-id="'+ count +'">Satuan</p></td><td class="pricePerUnit"><input type="text" readonly class="form-control pricePerUnit" value="0" data-id="'+ count +'" name="pricePerUnit[]"></td><td class="totalPrice"><input type="text" readonly class="form-control totalPrice" value="0" data-id="'+ count +'" name="totalPrice[]"></td></tr>';
                                        $('#tbody-stock').append(str);
                                        count += 1;
                                    } else {
                                        console.log('Tidak ada produk variation!')
                                    }
                                } else {
                                    console.log('Kesalahan Pengolahan Data')
                                }
                            }, error: function(error) {
                                console.log('Kesalahan dalam pengambilan data ke server!')
                            }
                        });
                    }
                });
                $(document).on('change', '.pricePerUnit', function(e){
                    e.preventDefault();let total = 0;
                    $(this).parent().parent().children('td.totalPrice').children().val((parseInt($(this).val()) * parseInt($(this).parent().parent().children('td.quantity').children().val())));
                    $('input.totalPrice').each(function(i, item) {
                        total += parseInt($(this).val());
                    })
                    $('#grand-total > span').html(formatNumber(total));
                });
                $(document).on('change', '.quantity', function(e){
                    e.preventDefault();let total = 0;
                    $(this).parent().parent().children('td.totalPrice').children().val((parseInt($(this).val()) * parseInt($(this).parent().parent().children('td.pricePerUnit').children().val())));
                    $('input.totalPrice').each(function(i, item) {
                        total += parseInt($(this).val());
                    })
                    $('#grand-total > span').html(formatNumber(total));
                });
                $(document).on('change', '.product-stock', function(e){
                    e.preventDefault();
                    let variant = variation.filter(item => { return (item.product_variation_id == $(this).val()) })
                    $(this).parent().parent().children('.satuan').children('p').html(variant[0].satuan)
                    $(this).parent().parent().children('.pricePerUnit').children('input').val(variant[0].price)
                    $(this).parent().parent().children('.quantity').children('input').removeAttr('readonly')
                });
            }
            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
            }
        });
    </script>
    @endif
    @if($title == 'Stok Keluar')
    <script>
        $(document).ready(function() {
            let variation = [], str = '', count = 1, i = 0, selected = [], temp = [];
            $('#stock-table').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                },
                "order": [[ 2, "desc" ]]
            });
            if (document.location.pathname.split('/').pop() == 'create') {
                $('#stock-addTable').click(function(e){
                    e.preventDefault();
                    if ($('#stock-create-table').children('tbody').children().length == variation.length){
                        alert("Kamu melebihi Baris yang diperkenankan!");
                    } else {
                        str = '<tr data-id="'+ count +'"><td><select class="product-stock form-control" data-id="'+ count +'" name="product[]"><option value="0">Pilih Produk</option>';
                        $.each(variation, function(i, item) {
                            str += '<option value="'+ item.product_variation_id +'">'+ item.title +'</option>';
                        });
                        str+= '</select></td><td class="quantity"><input type="number" data-id="'+ count +'" min="0" name="quantity[]" value="0" readonly class="form-control quantity"></td><td class="satuan"><p class="satuan" data-id="'+ count +'">Satuan</p></td><td class="pricePerUnit"><input type="text" class="form-control pricePerUnit" readonly value="0" data-id="'+ count +'" name="pricePerUnit[]"></td><td class="totalPrice"><input type="text" class="form-control totalPrice" value="0" data-id="'+ count +'" readonly name="totalPrice[]"></td></tr>';
                        $('#tbody-stock').append(str);count += 1;
                    }
                });
                $('#stock-removeTable').click(function(e){
                    e.preventDefault();
                    if($('#stock-create-table').children('tbody#tbody-stock').children().length == 2) { $('.product-stock').removeAttr('readonly') }
                    if ($('#stock-create-table').children('tbody#tbody-stock').children().length == 1){
                        alert("Tidak dapat menghapus baris!")
                    } else {
                        ($('#stock-create-table').children('tbody#tbody-stock').children().last().remove());count -= 1;
                        temp = (selected.filter(e => e.id != count));
                        selected = temp;let total = 0;
                        $('input.totalPrice').each(function(i, item) {
                            total += parseInt($(this).val());
                        })
                        $('#grand-total > span').html(addCommas(total));
                    }
                });
                $(document).on('change', '#outlet', function(e) {
                    e.preventDefault();$('#tbody-stock').children().remove();count = 0;$('.btn-option-table').css('display', 'none');$('.notify').css('display', 'inline-block');
                    if($(this).val() > 0) { $('.btn-option-table').css('display', 'inline');$('.notify').css('display', 'none');
                        $('#footer-table').css('display', 'inline-block');
                        $.ajax({
                            url: document.location.href,
                            method: 'POST',
                            dataType: 'JSON',
                            data: {
                                "_token" : $('meta[name="csrf-token"]').attr('content'),
                                "outlet": $(this).val()
                            },
                            success: function(data) {
                                if(data.status) {
                                    if(data.data.length > 0) {
                                        variation = (data.data);
                                        str = '<tr data-id="'+ count +'"><td><select class="product-stock form-control" data-id="'+1+'" name="product[]"><option value="0">Pilih Produk</option>';
                                        $.each(variation, function(i, item) {
                                            str += '<option value="'+ item.product_variation_id +'">'+ item.title +'</option>';
                                        });
                                        str+= '</select></td><td class="quantity"><input type="number" min="0" data-id="'+ count +'" name="quantity[]" readonly value="0" class="form-control quantity"></td><td class="satuan"><p class="satuan" data-id="'+ count +'">Satuan</p></td><td class="pricePerUnit"><input type="text" readonly class="form-control pricePerUnit" value="0" data-id="'+ count +'" name="pricePerUnit[]"></td><td class="totalPrice"><input type="text" readonly class="form-control totalPrice" value="0" data-id="'+ count +'" name="totalPrice[]"></td></tr>';
                                        $('#tbody-stock').append(str);
                                        count += 1;
                                    } else {
                                        console.log('Tidak ada produk variation!')
                                    }
                                } else {
                                    console.log('Kesalahan Pengolahan Data')
                                }
                            }, error: function(error) {
                                console.log('Kesalahan dalam pengambilan data ke server!')
                            }
                        });
                    }
                });

                $(document).on('change', '.product-stock', function(e){
                    if ((jQuery.isEmptyObject(selected))){
                        selected.push({ id: $(this).data('id'), val: $(this).val()});
                        $(this).attr('readonly', '')
                    } else {
                        if(selected.find( ({val}) => val == $(this).val() ) == undefined) {
                            if(selected.find(e => e.id == $(this).data('id'))){
                                temp = selected.filter(e => e.id != $(this).data('id'));
                                selected = temp;
                                selected.push({ id: $(this).data('id'), val: $(this).val()})
                                $(this).attr('readonly', '')
                            } else {
                                selected.push({ id: $(this).data('id'), val: $(this).val()})
                                $(this).attr('readonly', '')
                            }
                        } else {
                            ($(this).parent().parent().remove('tr'));count -= 1;
                            temp = selected.filter(e => e.id != $(this).data('id'));
                            selected = temp;let total = 0;
                            alert('Produk sudah dipilih di baris lain!')
                            $('input.totalPrice').each(function(i, item) {
                                total += parseInt($(this).val());
                            })
                            $('#grand-total > span').html(addCommas(total));
                        }
                    }
                });
                $(document).on('change', '.pricePerUnit', function(e){
                    e.preventDefault();let total = 0;
                    $(this).parent().parent().children('td.totalPrice').children().val((parseInt($(this).val()) * parseInt($(this).parent().parent().children('td.quantity').children().val())));
                    $('input.totalPrice').each(function(i, item) {
                        total += parseInt($(this).val());
                    });
                    $('#grand-total > span').html(addCommas(total));
                });
                $(document).on('change', '.quantity', function(e){
                    e.preventDefault();let total = 0;
                    $(this).parent().parent().children('td.totalPrice').children().val((parseInt($(this).val()) * parseInt($(this).parent().parent().children('td.pricePerUnit').children().val())));
                    $('input.totalPrice').each(function(i, item) {
                        total += parseInt($(this).val());
                    });
                    $('#grand-total > span').html(addCommas(total));

                });
                $(document).on('change', '.product-stock', function(e){
                    e.preventDefault();
                    let variant = variation.filter(item => { return (item.product_variation_id == $(this).val()) })
                    $(this).parent().parent().children('.satuan').children('p').html(variant[0].satuan)
                    $(this).parent().parent().children('.pricePerUnit').children('input').val(variant[0].price)
                    $(this).parent().parent().children('.quantity').children('input').attr('max', variant[0].stock).removeAttr('readonly')
                });
            }
        });
    </script>
    @endif
    @if($title == 'Stok Opname')
    <script>
        const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2
        });

        $(document).ready(function() {
            $('#stock-opname-table').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                },
                "order": [[ 0, "desc" ]]
            });
            if (window.location.pathname.split('/').pop() == 'create') {
                let variation = [], str = '', count = 1, i = 0, selected = [], temp = [];
                $(document).on('change', '.product-stock', function(e){
                    if ((jQuery.isEmptyObject(selected))){
                        selected.push({ id: $(this).data('id'), val: $(this).val()});
                        $(this).attr('readonly', '')
                    } else {
                        if(selected.find( ({val}) => val == $(this).val() ) == undefined) {
                            if(selected.find(e => e.id == $(this).data('id'))){
                                temp = selected.filter(e => e.id != $(this).data('id'));
                                selected = temp;
                                selected.push({ id: $(this).data('id'), val: $(this).val()})
                                $(this).attr('readonly', '')
                            } else {
                                selected.push({ id: $(this).data('id'), val: $(this).val()})
                                $(this).attr('readonly', '')
                            }
                        } else {
                            ($(this).parent().parent().remove('tr'));count -= 1;
                            temp = selected.filter(e => e.id != $(this).data('id'));
                            selected = temp;let total = 0;
                            alert('Produk sudah dipilih di baris lain!')
                            $('input.totalPrice').each(function(i, item) {
                                total += parseInt($(this).val());
                            })
                            $('#grand-total > span').html(formatNumber(total));
                        }
                    }
                });
                $('#stock-addTable').click(function(e){
                    e.preventDefault();
                    if ($('#stock-opname-create-table').children('tbody').children().length == variation.length){
                        alert("Kamu melebihi Baris yang diperkenankan!");
                    } else {
                        str = '<tr data-id="'+ count +'"><td><select class="product-stock form-control" data-id="'+ count +'" name="product[]"><option value="0">Pilih Produk</option>';
                        $.each(variation, function(i, item) {
                            str += '<option value="'+ item.product_variation_id +'">'+ item.title +'</option>';
                        });
                        str+= '</select></td><td class="jmlBrgSis"><input type="text" readonly class="form-control jmlBrgSis" value="0" name="jmlBrgSis[]" data-id="'+ count +'"></td><td class="jmlBrgAkt"><input type="number" class="form-control jmlBrgAkt" readonly name="jmlBrgAkt[]" value="0" min="0" data-id="'+ count +'"></td><td class="satuan"><p class="satuan" data-id="'+ count +'">Satuan</p></td><td class="deviation"><input type="text" readonly class="form-control deviation" value="0" name="deviation[]" data-id="'+ count +'"></td><td class="prcPerUntSis"><input type="text" class="form-control prcPerUntSis" readonly value="0" name="prcPerUntSis[]" data-id="'+ count +'"></td><td class="prcPerUntAkt"><input type="text" class="form-control readonly prcPerUntAkt" name="prcPerUntAkt[]" value="0" data-id="'+ count +'"></td></tr>';
                        $('#tbody-stock-opname').append(str);count += 1;
                    }
                });
                $('#stock-removeTable').click(function(e){
                    e.preventDefault();
                    if($('#stock-opname-create-table').children('tbody#tbody-stock-opname').children().length == 2) { $('.product-stock').removeAttr('readonly') }
                    if ($('#stock-opname-create-table').children('tbody#tbody-stock-opname').children().length == 1){
                        alert("Tidak dapat menghapus baris!")
                    } else {
                        ($('#stock-opname-create-table').children('tbody#tbody-stock-opname').children().last().remove());count -= 1;
                        temp = (selected.filter(e => e.id != count));
                        selected = temp;
                    }
                    });
                $(document).on('change', '.product-stock', function(e){
                    e.preventDefault();
                    let variant = variation.filter(item => { return (item.product_variation_id == $(this).val()) })
                    $(this).parent().parent().children('.satuan').children('p').html(variant[0].satuan)
                    $(this).parent().parent().children('.jmlBrgSis').children('input').val(variant[0].stock)
                    $(this).parent().parent().children('.jmlBrgAkt').children('input').removeAttr('readonly');
                    $(this).parent().parent().children('.prcPerUntSis').children('input').val(addCommas(variant[0].price));
                    $(this).parent().parent().children('.prcPerUntAkt').children('input').val(addCommas(variant[0].price)).removeAttr('readonly');
                });
                $(document).on('input', '.jmlBrgAkt', function(e){
                    e.preventDefault();
                    let calculate = parseInt($(this).parent().children('.jmlBrgSis').children('input').val()) - parseInt($(this).children().val());$(this).parent().children('.deviation').children('input').val(calculate);
                });
                $(document).on('change', '#outlet', function(e) {
                    e.preventDefault();$('#tbody-stock-opname').children().remove();count = 0;$('.btn-option-table').css('display', 'none');$('.notify').css('display', 'block');
                    if($(this).val() > 0) { $('.btn-option-table').css('display', 'inline');$('.notify').css('display', 'none');
                        $.ajax({
                            url: document.location.href,
                            method: 'POST',
                            dataType: 'JSON',
                            data: {
                                "_token" : $('meta[name="csrf-token"]').attr('content'),
                                "outlet": $(this).val()
                            },
                            success: function(data) {
                                if(data.status) {
                                    if(data.data.length > 0) {
                                        variation = (data.data);
                                        str = '<tr data-id="'+ count +'"><td><select class="product-stock form-control" data-id="'+1+'" name="product[]"><option value="0">Pilih Produk</option>';
                                        $.each(variation, function(i, item) {
                                            str += '<option value="'+ item.product_variation_id +'">'+ item.title +'</option>';
                                        });
                                        str+= '</select></td><td class="jmlBrgSis"><input type="text" readonly class="form-control jmlBrgSis" value="0" name="jmlBrgSis[]" data-id="'+ count +'"></td><td class="jmlBrgAkt"><input type="number" min="0" value="0" class="form-control jmlBrgAkt" readonly name="jmlBrgAkt[]" data-id="'+ count +'"></td><td class="satuan"><p class="satuan" data-id="'+ count +'">Satuan</p></td><td class="deviation"><input type="text" readonly class="form-control deviation" value="0" name="deviation[]" data-id="'+ count +'"></td><td class="prcPerUntSis"><input type="text" class="form-control prcPerUntSis" readonly value="0" name="prcPerUntSis[]" data-id="'+ count +'"></td><td class="prcPerUntAkt"><input type="text" class="form-control prcPerUntAkt" name="prcPerUntAkt[]" value="0" readonly data-id="'+ count +'"></td></tr>';
                                        $('#tbody-stock-opname').append(str);
                                        count += 1;
                                    } else {
                                        console.log('Tidak ada produk variation!')
                                    }
                                } else {
                                    console.log('Kesalahan Pengolahan Data')
                                }
                            }, error: function(error) {
                                console.log('Kesalahan dalam pengambilan data ke server!')
                            }
                        });
                    }
                });
            }
        });
    </script>
    @endif
    @if($title == 'Stok Transfer')
    <script>
        $(document).ready(function() {
            let datatable, table = '', fromDate = '', toDate = '';
            $('#stock-table').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                },
                "order": [[ 0, "desc" ]]
            });

            if (window.location.pathname.split('/').pop() == 'create') {
                let variation = [], str = '', count = 1, i = 0, selected = [], temp = [];
                $(document).on('change', '.product-stock', function(e){
                    if ((jQuery.isEmptyObject(selected))){
                        selected.push({ id: $(this).data('id'), val: $(this).val()});
                        $(this).attr('readonly', '')
                    } else {
                        if(selected.find( ({val}) => val == $(this).val() ) == undefined) {
                            if(selected.find(e => e.id == $(this).data('id'))){
                                temp = selected.filter(e => e.id != $(this).data('id'));
                                selected = temp;
                                selected.push({ id: $(this).data('id'), val: $(this).val()})
                                $(this).attr('readonly', '')
                            } else {
                                selected.push({ id: $(this).data('id'), val: $(this).val()})
                                $(this).attr('readonly', '')
                            }
                        } else {
                            ($(this).parent().parent().remove('tr'));count -= 1;
                            temp = selected.filter(e => e.id != $(this).data('id'));
                            selected = temp;let total = 0;
                            alert('Produk sudah dipilih di baris lain!')
                            $('input.totalPrice').each(function(i, item) {
                                total += parseInt($(this).val());
                            })
                            $('#grand-total > span').html(formatNumber(total));
                        }
                    }
                });
                $('#stock-addTable').click(function(e){
                    e.preventDefault();
                    if ($('#stock-create-table').children('tbody').children().length == variation.length){
                        alert("Kamu melebihi Baris yang diperkenankan!");
                    } else {
                        str = '<tr data-id="'+ count +'"><td><select class="product-stock form-control" data-id="'+ count +'" name="product[]"><option value="0">Pilih Produk</option>';
                        $.each(variation, function(i, item) {
                            str += '<option value="'+ item.product_variation_id +'">'+ item.title +'</option>';
                        });
                        str+= '</select></td><td class="stockAvailable"><input type="text" class="form-control" readonly name="stockAvailable[]" data-id="'+ count +'" value="0"></td><td class="quantity"><input min="0" type="number" data-id="'+ count +'" name="quantity[]" value="0" class="form-control quantity"></td><td class="satuan"><p class="satuan" data-id="'+ count +'">Satuan</p></td></tr>';
                        $('#tbody-stock').append(str);count += 1;
                    }
                });
                $('#stock-removeTable').click(function(e){
                    e.preventDefault();
                    if($('#stock-create-table').children('tbody#tbody-stock').children().length == 2) { $('.product-stock').removeAttr('readonly') }
                    if ($('#stock-create-table').children('tbody#tbody-stock').children().length == 1){
                        alert("Tidak dapat menghapus baris!")
                    } else {
                        ($('#stock-create-table').children('tbody#tbody-stock').children().last().remove());count -= 1;
                        temp = (selected.filter(e => e.id != count));
                        selected = temp;let total = 0;
                        $('input.totalPrice').each(function(i, item) {
                            total += parseInt($(this).val());
                        })
                        $('#grand-total > span').html(formatNumber(total));
                    }
                    });
                $(document).on('change', '.product-stock', function(e){
                    e.preventDefault();
                    let variant = variation.filter(item => { return (item.product_variation_id == $(this).val()) })
                    $(this).parent().parent().children('.satuan').children('p').html(variant[0].satuan)
                    $(this).parent().parent().children('.stockAvailable').children('input').val(variant[0].stock)
                    $(this).parent().parent().children('.quantity').children('input').attr('max', variant[0].stock)
                });
                $(document).on('change', '#byOutlet', function(e) {
                    e.preventDefault();$('#tbody-stock').children().remove();count = 0;$('.btn-option-table').css('display', 'none');
                    if($(this).val() > 0) { $('.btn-option-table').css('display', 'inline');
                        $('.notice').css('display', 'none')
                        $.ajax({
                            url: document.location.href,
                            method: 'POST',
                            dataType: 'JSON',
                            data: {
                                "_token" : $('meta[name="csrf-token"]').attr('content'),
                                "by_outlet": $(this).val()
                            },
                            success: function(data) {
                                if(data.status) {
                                    if(data.data.length > 0) {
                                        variation = (data.data);
                                        str = '<tr data-id="'+ count +'"><td><select class="product-stock form-control" data-id="'+1+'" name="product[]"><option value="0">Pilih Produk</option>';
                                        $.each(variation, function(i, item) {
                                            str += '<option value="'+ item.product_variation_id +'">'+ item.title +'</option>';
                                        });
                                        str+= '</select></td><td class="stockAvailable"><input type="text" class="form-control" readonly name="stockAvailable[]" data-id="'+ count +'" value="0"></td><td class="quantity"><input type="number" data-id="'+ count +'" name="quantity[]" min="0" value="0" class="form-control quantity"></td><td class="satuan"><p class="satuan" data-id="'+ count +'">Satuan</p></td></tr>';
                                        $('#tbody-stock').append(str);
                                        count += 1;
                                    } else {
                                        console.log('Tidak ada produk variation!')
                                    }
                                } else {
                                    console.log('Kesalahan Pengolahan Data')
                                }
                            }, error: function(error) {
                                console.log('Kesalahan dalam pengambilan data ke server!')
                            }
                        });
                    }
                })
                $('#byOutlet').change(function(e) {
                    e.preventDefault();
                    preventSameOutlet('byOutlet');
                });
                $('#toOutlet').change(function(e) {
                    e.preventDefault();
                    preventSameOutlet('toOutlet');
                });
            }
            function preventSameOutlet(data) {
                if($('#byOutlet').val() == $('#toOutlet').val()){
                    alert('Outlet Tidak boleh Sama!');
                    if(data == 'toOutlet') {
                        $('#toOutlet').val(0);
                    } else if (data == 'byOutlet'){
                        $('#byOutlet').val(0);
                        $('.notice').css('display', 'block')
                        count = 0;
                    } else {
                        alert('No option!');
                    }
                } else {return;}
            }
        });
    </script>
    @endif
    @if($title == 'Produk')
    <script>
        $(function() {
            $('#product-table').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                }
            });
            $('#variant-product-table').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                }
            });
            $('select#imageSelect').change(function() {
                if ($(this).val() == 0) {
                    $('#img-preview-create').removeAttr('style')
                } else {
                    $('#img-preview-create').css('display', 'none')
                }
            });
            let oldImage = '';
            $('#image-preview').change(event => {
                event.preventDefault();
                $('select#imageSelect').attr('disabled', '');
                if (event.target.files && event.target.files[0]) {
                    var reader = new FileReader();
                    reader.readAsDataURL(event.target.files[0]);
                    reader.onload = function(e) {
                        $('.img-variant').attr('src', e.target.result);
                        $('.img-variant').toggle('slow');
                        $('.btn-times-image-variant').toggle('slow');
                        $('#img-preview-create').toggle('slow');
                    }
                }
            });
            $('#image-preview-edit').change(event => {
                oldImage = $('.img-variant').attr('src');
                event.preventDefault();
                if (event.target.files && event.target.files[0]) {
                    var reader = new FileReader();
                    reader.readAsDataURL(event.target.files[0]);
                    reader.onload = function(e) {
                        $('#image-preview-edit-div').toggle('slow');
                        $('.img-variant').attr('src', e.target.result);
                        $('.btn-times-image-variant').toggle('slow');
                    }
                }
            });
            $('.btn-times-image-variant').click(e => {
                e.preventDefault();
                $('select#imageSelect').removeAttr('disabled');
                $('#img-preview-create').toggle('slow');
                $('#image-preview-edit').val('');
                $('.btn-times-image-variant').toggle('slow');
                $('#image-preview-edit-div').toggle('slow');
                if (window.location.pathname.split('/').pop() == 'varian') {
                    $('.img-variant').attr('src', '');
                    $('.img-variant').toggle('slow');
                } else {
                    $('.img-variant').attr('src', oldImage);
                }
            });
        });
    </script>
    @endif
    @if($title == 'Bahan Mentah')
    <script>
        $(function() {
            $('#material-table').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                }
            });
            $('#stock-edit-table').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                }
            });
            let oldImage = '';
            $('#image-preview').change(event => {
                event.preventDefault();
                if (event.target.files && event.target.files[0]) {
                    var reader = new FileReader();
                    reader.readAsDataURL(event.target.files[0]);
                    reader.onload = function(e) {
                        $('.img-material').attr('src', e.target.result);
                        $('.img-material').toggle('slow');
                        $('.btn-times-image-material').toggle('slow');
                        $('#img-preview-create').toggle('slow');
                    }
                }
            });
            $('#image-preview-edit').change(event => {
                oldImage = $('.img-material').attr('src');
                event.preventDefault();
                if (event.target.files && event.target.files[0]) {
                    var reader = new FileReader();
                    reader.readAsDataURL(event.target.files[0]);
                    reader.onload = function(e) {
                        $('#image-preview-edit-div').toggle('slow');
                        $('.img-material').attr('src', e.target.result);
                        $('.btn-times-image-material').toggle('slow');
                    }
                }
            });
            $('.btn-times-image-material').click(e => {
                e.preventDefault();
                $('#img-preview-create').toggle('slow');
                $('#image-preview-edit').val('');
                $('.btn-times-image-material').toggle('slow');
                $('#image-preview-edit-div').toggle('slow');
                if (window.location.pathname.split('/').pop() == 'create') {
                    $('.img-material').attr('src', '');
                    $('.img-material').toggle('slow');
                } else {
                    $('.img-material').attr('src', oldImage);
                }
            });
            $('.stock-edit').on('change', function(e) {
                e.preventDefault();
                console.log($('.stock-edit').val())
            })
        });
    </script>
    @endif
    @if($title == 'Kategori')
    <script>
        $(function() {
            let oldImage = '';
            $('#category-table').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                }
            });
            $('#image-preview').change(event => {
                event.preventDefault();
                if (event.target.files && event.target.files[0]) {
                    var reader = new FileReader();
                    reader.readAsDataURL(event.target.files[0]);
                    reader.onload = function(e) {
                        $('.img-category').attr('src', e.target.result);
                        $('.img-category').toggle('slow');
                        $('.btn-times-image-category').toggle('slow');
                        $('#img-preview-create').toggle('slow');
                    }
                }
            });
            $('#image-preview-edit').change(event => {
                oldImage = $('.img-category').attr('src');
                event.preventDefault();
                if (event.target.files && event.target.files[0]) {
                    var reader = new FileReader();
                    reader.readAsDataURL(event.target.files[0]);
                    reader.onload = function(e) {
                        $('#image-preview-edit-div').toggle('slow');
                        $('.img-category').attr('src', e.target.result);
                        $('.btn-times-image-category').toggle('slow');
                    }
                }
            });
            $('.btn-times-image-category').click(e => {
                e.preventDefault();
                $('#img-preview-create').toggle('slow');
                $('#image-preview-edit').val('');
                $('.btn-times-image-category').toggle('slow');
                $('#image-preview-edit-div').toggle('slow');
                if (window.location.pathname.split('/').pop() == 'create') {
                    $('.img-category').attr('src', '');
                    $('.img-category').toggle('slow');
                } else {
                    $('.img-category').attr('src', oldImage);
                }
            })
        });
    </script>
    @endif
    @if($title == 'Promo')
    <link href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/locales/bootstrap-datepicker.id.min.js"></script>

    <script>
        $(function() {
            $('.select-promo-outlet').select2();
            $('#table-special-promo').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                }
            });
            $('#table-voucher-promo').DataTable({
                "language" : {
                    "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
                }
            });
            $('.input-daterange input').each(function() {
                $(this).datepicker({
                    language: 'id'
                });
            });
            $('#refresh-code-voucher').click(e => {
                e.preventDefault();
                $.ajax({method: 'get', url: window.location.origin + '/promo/code', dataType: 'json', success: function(data) {
                    if(data.message == 'success') $('#code').val(data.code);
                }, error: function(e){ console.log("error: " + e) }});
            });
        })
    </script>
    @endif
    @if($title == 'Karyawan')

    <script>
        $('.select-employee-outlet').select2();
        $('#log-employee-table').DataTable({
            "order" : [[0, "desc"]],
            "language" : {
                "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
            }
        });
        $('#employees-table').DataTable({
            "language" : {
                "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
            }
        });
        $('#image-preview').change(event => {
            event.preventDefault();
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();
                reader.readAsDataURL(event.target.files[0]);
                reader.onload = function(e) {
                    $('.img-employee').attr('src', e.target.result);
                    $('.img-employee').toggle('slow');
                    $('#image-preview').toggle('slow');
                    $('.btn-times-image-employee').toggle('slow');
                }
            }
        });
        $('.btn-times-image-employee').click(e => {
            e.preventDefault();
            $('.btn-times-image-employee').toggle('slow');
            $('#image-preview').toggle('slow');
            $('#image-preview').val('');
            $('.img-employee').toggle('slow');
        });
    </script>
    @endif
    @if($title == 'Supplier')
    <script>
        $('#taxSupplier').select2();
        $('#supplier-table').DataTable({
            "language" : {
                "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
            }
        });
    </script>
    @endif
    @if($title == 'Outlet')
    <script>
        $('.select-tax-outlet').select2();
        $('#outlet-table').DataTable({
            "language" : {
                "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
            }
        });
        if(document.location.pathname.split('/').pop() == 'create' || document.location.pathname.split('/').pop() == 'edit') {
            let location = '', oldLocation = {lat: parseFloat($('#lat_location').val()), lng: parseFloat($('#lng_location').val()) }, text='';
            function initMap() {
                if(document.location.pathname.split('/').pop() == 'edit') {
                    var myLatlng = oldLocation;
                    text="Lokasi Outlet Saat Ini!\nPilih Lokasi Lainnya Jika ingin diubah"
                } else {
                    var myLatlng = {lat: -6.3080942, lng: 106.827183};
                    text = 'Klik Tempat Outlet Berada!'
                }
                var map = new google.maps.Map(
                    document.getElementById('maps'), {zoom: 12, center: myLatlng});
                if(document.location.pathname.split('/').pop() == 'edit') {
                    var marker = new google.maps.Marker({position: oldLocation, map: map});
                }
                var infoWindow = new google.maps.InfoWindow(
                    {content: text, position: myLatlng});
                infoWindow.open(map);
                map.addListener('click', function(mapsMouseEvent) {
                    infoWindow.close();
                    infoWindow = new google.maps.InfoWindow({position: mapsMouseEvent.latLng});
                    location = mapsMouseEvent.latLng.toString();
                    infoWindow.setContent('Pilih Lokasi Disini');
                    infoWindow.open(map);
                    location = (location.replace('(', '').replace(')', '').split(', '))
                    $('#lat_location').attr('value', location[0])
                    $('#lng_location').attr('value', location[1])
                });
            }
        }
    </script>
    @endif
    @if($title == 'Pajak & Services')
    <script>
        $('.select-tax-outlet').select2();
        $('#tax-table').DataTable({
            "language" : {
                "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
            }
        });
    </script>
    @endif
    @if($title == 'Purchase Order')
    <script>
        $('#purchase-table').DataTable({
            "language" : {
                "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
            }
        });
    </script>
    @endif
    @if($title == 'Pelanggan')
    <script>
    $(function() {
        $('#customers-table').DataTable({
            "language" : {
                "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
            }
        });
        $('#transaction-history-table').DataTable({
            "language" : {
                "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
            }
        });
        $('#image-preview').change(event => {
            event.preventDefault();
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();
                reader.readAsDataURL(event.target.files[0]);
                reader.onload = function(e) {
                    $('.img-customer').attr('src', e.target.result);
                    $('.img-customer').toggle('slow');
                    $('.btn-times-image-customer').toggle('slow');
                }
            }
        });
        $('.btn-times-image-customer').click(e => {
            e.preventDefault();
            $('.btn-times-image-customer').toggle('slow');
            $('.img-customer').toggle('slow');
            $('#image-preview').val('');
        })
    });
    </script>
    @endif
    @if($title == 'Profil')
    <script>
    $(function() {
        let image = '';
        $('#show-input-image').click(e => {
            e.preventDefault();
            $('#image-preview').toggle('slow');
        })
        $('#image-preview').change(event => {
            event.preventDefault();
                    if(image == '') {
                        $('#undo-preview-image').toggle('slow');
                        image = $('.img-profile').attr('src');
                    }
            $('#imageClear').val('0');
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();
                reader.readAsDataURL(event.target.files[0]);
                reader.onload = function(e) {
                    $('.img-profile').attr('src', e.target.result);
                }
            }
        });
        $('#log-profile-table').DataTable({
            "order" : [[0, "desc"]],
            "language" : {
                "url" : "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian-Alternative.json"
            }
        });
        $('#undo-preview-image').click(e => {
            if(image != '' ) {
                e.preventDefault();
                $('#imageClear').val('0');
                $('#image-preview').val("");
                $('.img-profile').attr('src', image);
                image = '';
                $('#undo-preview-image').toggle('slow')
            }
        })
        $('.img-delete').click(e => {
            if(image == '') {
                e.preventDefault();
                $('#undo-preview-image').toggle('slow')
                image = $('.img-profile').attr('src');
                $('#imageClear').val('1');
                $('.img-profile').attr('src', (window.location.origin + '/images/profile/nophoto.png'));
            }
        })
    })
    </script>@endif
</body>
</html>
