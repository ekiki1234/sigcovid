@extends('layout.master2')
@section('title','Dashboard')
@section('content')
    
    <section class="content">
        <div class="container-fluid">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            @if ($kabupatenBelumUpdate->count() > 0)
                            <h2>
                                Data Kabupaten Yang Belum Diupdate per <strong>{{$tanggalSekarang}}</strong>
                            </h2>
                            <p>
                                @foreach ($kabupatenBelumUpdate as $item)
                                {{$item->kabupaten}} ,
                                @endforeach    
                            </p>
                            @else
                                <p>
                                    Semua Data Kabupaten Sudah Ter-update
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Manajemen Data
                            </h2>
                        </div>
                        <div class="body">
                            <form  action="/data-kabupaten" method="POST">
                            @csrf
                                <label for="kabupaten">Kabupaten</label>
                                <div class="form-group">
                                    <select class="form-control" name="kabupaten" required>
                                        @foreach ($kabupaten as $item)
                                            <option value="{{$item->id}}">{{ucfirst($item->kabupaten)}}</option>      
                                        @endforeach
                                    </select>
                                </div>
                                <label for="tanggal">Tanggal</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" id="tanggal" name="tanggal" class="form-control" placeholder="Enter value" required>
                                    </div>
                                </div>
                                <label for="sembuh">Sembuh</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" name="sembuh" min="0" id="sembuh" class="form-control" placeholder="Enter value">
                                    </div>
                                </div>
                                <label for="dirawat">Dirawat</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" name="rawat" min="0" id="dirawat" class="form-control" placeholder="Enter value">
                                    </div>
                                </div>
                                <label for="meninggal">Meninggal</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" min="0" id="meninggal" name="meninggal" class="form-control" placeholder="Enter value">
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary form-control" >Input</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
        </div>
    </section>
@endsection
