@extends('layout.master2')
@section('title','Dashboard')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Tanggal {{$tanggalSekarang}}</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">playlist_add_check</i>
                        </div>
                        <div class="content">
                            <div class="text">Positif</div>
                            {{$totalPositif[0]->positif}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">help</i>
                        </div>
                        <div class="content">
                            <div class="text">Sembuh</div>
                            {{$totalSembuh[0]->sembuh}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">forum</i>
                        </div>
                        <div class="content">
                            <div class="text">Dirawat</div>
                            {{$totalDirawat[0]->rawat}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">Meninggal</div>
                            {{$totalMeninggal[0]->meninggal}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
            <!--Bootstrap Date Picker -->
            <form action="/search" method="POST">
            @csrf
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <h2 class="card-inside-title">Cari Tanggal</h2>
                                    
                                        <div class="input-group date" id="bs_datepicker_component_container">
                                            <div class="form-line">
                                                <input id="tanggalSearch" type="date" @if(isset($tanggal)) value="{{$tanggal}}" @endif name="tanggal" class="form-control" required>
                                            </div>
                                            <button class="btn btn-primary form-control" >Cari</button>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <!--#END# Bootstrap Date Picker -->
            <!-- CPU Usage -->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>Peta Penyebaran COVID-19 Provinsi Bali {{$tanggalSekarang}}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div id="mapid" style="height: 500px"></div>
                        </div>
                        Color Start
                        <input type="color" value="#edff6b" class="form-control" id="colorStart">
                        Color End
                        <input type="color" value="#6b6a01" class="form-control" id="colorEnd">
                        <button class="btn btn-primary form-control" id="btnGenerateColor" >Generate</button>
                    </div>
                </div>
              </div>
            
            <!-- #END# CPU Usage -->

            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>TASK INFOS</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Kabupaten</th>
                                        <th>Positif</th>
                                        <th>Meninggal</th>
                                        <th>Sembuh</th>
                                        <th>Dirawat</th>
                                        {{-- <th>Tanggal</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                        <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ucfirst($item->kabupaten)}}</td>
                                        <td>{{$item->positif}}</td>
                                        <td>{{$item->meninggal}}</td>
                                        <td>{{$item->sembuh}}</td>
                                        <td>{{$item->rawat}}</td>
                                        {{-- <td>{{$item->tanggal}}</td> --}}
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Task Info -->
            </div>
        </div>
    </section>
        
@endsection
@section("js")
<script src="https://unpkg.com/leaflet-kmz@latest/dist/leaflet-kmz.js"></script>
<script>
  $(document).ready(function () {
    var dataMap=null;
    var colorMap=[
      "edff6b",
      "dcec5d",
      "ccd950",
      "bcc743",
      "acb436",
      "9ba128",
      "8b8f1b",
      "7b7c0e",
      "6b6a01"
    ];
    var tanggal = $('#tanggalSearch').val();
    console.log(tanggal);
    $.ajax({
      async:false,
      url:'getDataMap',
      type:'get',
      dataType:'json',
      data:{date: tanggal},
      success: function(response){
        dataMap = response;
      }
    });
    console.log(dataMap);
    var map = L.map('mapid',{
      fullscreenControl:true,
    });
    
    $('#btnGenerateColor').on('click',function(e){
      var colorStart = $('#colorStart').val();
      var colorEnd = $('#colorEnd').val();
      $.ajax({
        async:false,
        url:'/create-pallete',
        type:'get',
        dataType:'json',
        data:{start: colorStart, end:colorEnd},
        success: function(response){
          colorMap = response;
          setMapColor();
          
        }
      });
      
    });
    
    
    map.setView(new L.LatLng(-8.500410, 115.195839),9);
    var OpenTopoMap = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 20,
            // zoomAnimation:true,
            id: 'mapbox/streets-v11',
            // tileSize: 512,
            // zoomOffset: -1,
            accessToken: 'pk.eyJ1Ijoid2lkaWFuYXB3IiwiYSI6ImNrNm95c2pydjFnbWczbHBibGNtMDNoZzMifQ.kHoE5-gMwNgEDCrJQ3fqkQ',
        }).addTo(map);
    OpenTopoMap.addTo(map);
    var defStyle = {opacity:'1',color:'#000000',fillOpacity:'0',fillColor:'#CCCCCC'};
    setMapColor();
    
    function setMapColor(){
      var BADUNG,BULELENG,BANGLI,DENPASAR,GIANYAR,JEMBRANA,KARANGASEM,KLUNGKUNG,TABANAN;
      dataMap.forEach(function(value,index){
        
        var colorKab = dataMap[index].kabupaten.toUpperCase();
        if(colorKab == "BADUNG"){
          BADUNG = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="BULELENG"){
          BULELENG = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        } else if(colorKab=="BANGLI"){
          BANGLI = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="DENPASAR"){
          DENPASAR = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="GIANYAR"){
          GIANYAR = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab =="JEMBRANA"){
          JEMBRANA = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="KARANGASEM"){
          KARANGASEM = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="TABANAN"){
          TABANAN = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab =="KLUNGKUNG"){
          KLUNGKUNG = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }

      });
      var kmzParser = new L.KMZParser({
          onKMZLoaded: function (kmz_layer, name) {
              control.addOverlay(kmz_layer, name);
              var layers = kmz_layer.getLayers()[0].getLayers();
              layers.forEach(function(layer, index){
                var kab  = layer.feature.properties.NAME_2;
                kab = kab.toUpperCase();
                var kabLower = kab.toLowerCase();

                if(!Array.isArray(dataMap) || !dataMap.length == 0){
                // set sub layer default style positif covid
                  // var STYLE = {opacity:'1',color:'#000',fillOpacity:'1',fillColor:'#'+colorMap[index]}; 
                  // layer.setStyle(STYLE);
                  if(kab == 'BADUNG'){
                    layer.setStyle(BADUNG);
                  }else if(kab == 'BANGLI'){
                    layer.setStyle(BANGLI);
                  }else if(kab == 'BULELENG'){
                    layer.setStyle(BULELENG);
                  }else if(kab == 'DENPASAR'){
                    layer.setStyle(DENPASAR);
                  }else if(kab == 'GIANYAR'){
                    layer.setStyle(GIANYAR);
                  }else if(kab == 'JEMBRANA'){
                    layer.setStyle(JEMBRANA);
                  }else if(kab == 'KARANGASEM'){
                    layer.setStyle(KARANGASEM);
                  }else if(kab == 'KLUNGKUNG'){
                    layer.setStyle(KLUNGKUNG);
                  }else if(kab == 'TABANAN'){
                    layer.setStyle(TABANAN);
                  } 
                  var data = '<table width="300">';
                    data +='  <tr>';
                    data +='    <th colspan="2">Keterangan</th>';
                    data +='  </tr>';
                  
                    data +='  <tr>';
                    data +='    <td>Kabupaten</td>';
                    data +='    <td>: '+kab+'</td>';
                    data +='  </tr>';              
    
                    data +='  <tr style="color:red">';
                    data +='    <td>Positif</td>';
                    data +='    <td>: '+dataMap[index].positif+'</td>';
                    data +='  </tr>';

                    data +='  <tr style="color:green">';
                    data +='    <td>Sembuh</td>';
                    data +='    <td>: '+dataMap[index].sembuh+'</td>';
                    data +='  </tr>'; 

                    data +='  <tr style="color:black">';
                    data +='    <td>Meninggal</td>';
                    data +='    <td>: '+dataMap[index].meninggal+'</td>';
                    data +='  </tr>';

                    data +='  <tr style="color:blue">';
                    data +='    <td>Dalam Perawatan</td>';
                    data +='    <td>: '+dataMap[index].rawat+'</td>';
                    data +='  </tr>';               
                                  
                    data +='</table>';
                }else{
                  var data = "Tidak ada Data pada tanggal tersebut"
                  layer.setStyle(defStyle);
                }
                layer.bindPopup(data);
              });
              kmz_layer.addTo(map);
          }
      });
      kmzParser.load('bali-kabupaten.kmz');
      var control = L.control.layers(null, null, {
          collapsed: true
      }).addTo(map);
      $('.leaflet-control-layers').hide();

    }
  });
</script>

@endsection


