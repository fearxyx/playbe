<div class="modal fade {{ Session::has('video') ? "in" : ''}}"  id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="upload-modal" aria-hidden="true" style="{{ Session::has('video') ? "display:block" : ''}}">
    <div class="modal-dialog" role="document">
        <div hidden style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;z-index: 99999999999999;background: rgba(0, 0, 0, 0.87);" id="loader">
            <h3 style="color: white;margin: 30px 5px;text-align: center;">Soubor se nahrává, nezavírejte prosím prohlížeč. </h3>
            <div class="loader">
                <div class="inner one"></div>
                <div class="inner two"></div>
                <div class="inner three"></div>
            </div>
        </div>
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="exampleModalLabel">Upload</h4>
                </div>
            <div class="modal-body">
                @include('partials.message')
                <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ secure_url(URL('/upload/file',[], config('app.img'))) }}">
                    {{ csrf_field() }}
                    @guest
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mailová adresa</label>

                        <div class="col-md-6">
                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    @endguest
                    <div class="form-group text-center{{ $errors->has('videoFile')? ' has-error' : '' }}">
                        <div class="fileupload fileupload-new{{ $errors->has('videoFile') ? ' has-error' : '' }}" data-provides="fileupload">
                    <span class="btn btn-primary btn-file"><span class="fileupload-new">Vybrat soubor video</span>
                    <span class="fileupload-exists">Zmenit</span><input style="position: absolute;left: 226%;right: 0;height: 10px;" class="col-md-5" type="file" name="videoFile" accept="video/*" required /></span>
                            <span class="fileupload-preview" id="video-Name"></span>
                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                        </div>
                        @if ($errors->has('videoFile'))
                            <span class="help-block"><strong>{{ $errors->first('videoFile') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group text-center{{ $errors->has('titleFile')? ' has-error' : '' }}">
                        <div class="fileupload fileupload-new{{ $errors->has('titleFile') ? ' has-error' : '' }}" data-provides="fileupload">
                    <span class="btn btn-primary btn-file"><span  class="fileupload-new">Vybrat soubor titulků</span>
                    <span class="fileupload-exists">Zmenit</span><input style="position: absolute;left: 226%;right: 0;height: 10px;" type="file" name="titleFile" /></span>
                            <span class="fileupload-preview"></span>
                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                        </div>
                        @if ($errors->has('titleFile'))
                            <span class="help-block"><strong>{{ $errors->first('titleFile') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group text-center">
                        <div class="podmienky-cont{{ $errors->has('podmienki') ? ' has-error' : '' }}">
                            <a style="color: black!important;margin-top: 10px" href="{{ secure_url(URL::route("home.podmienky.uziti",[],config('app.http2') )) }}" role="button" target="_blank" class="podm-check bold podmienky text-right">
                                Souhlasím z podmínky použití SerialHD.cz
                            </a>
                                {{ Form::checkbox('podmienki', 1, null, ['class' => 'checkboxPodmienky form-control  ',  'id' => 'CheckboxPodmienki' , 'required' => 'required']) }}
                            @if ($errors->has('podmienki'))
                                <div class="col-md-6 col-md-offset-6">
                                    <span class="help-block text-right"><strong>{{ $errors->first('podmienki') }}</strong></span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button id="submitUpload" type="submit" class="btn-primary btn" onclick="">
                                Nahrát
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="close-uploads" type="button" class="btn-danger btn-primary btn" data-dismiss="modal">Zavřít</button>
            </div>
        </div>
    </div>
</div>
</div>