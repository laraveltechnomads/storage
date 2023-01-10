<div class="modal-header">
    <h5 class="modal-title" id="demoModalLabel">{{ __('Blog List')}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="col-md-12">
    <div class="card-block">
        <div class="table">
            <table class="table table-hover mb-0">
                {{-- <thead>
                    <tr>
                        <th>Subject</th>
                        <th>End Date</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <tr>
                        <td style="background-color: none;">Blog Title :</td>
                        <td>{{ Str::title($blog->title)}}</td>
                    </tr>
                    <tr>
                        <td>Meta Title :</td>
                        <td>{{ Str::title($blog->meta_title)}}</td>
                    </tr>
                    <tr>
                        <td>Meta Description :</td>
                        <td>{{ Str::title($blog->meta_description)}}</td>
                    </tr>
                    <tr>
                        <td>Blog Tags :</td>
                        <td>
                            <li>{{ tag_name($blog->tag_id)->implode(', ') }}</li>
                        </td>
                    </tr>
                    <tr>
                        <td>Feature Image :</td>
                        <td><img src="{{asset('/images/blogs').'/'.$blog->feature_image}}" height="200px;" width="200px;"></td>
                    </tr>
                    <tr>
                        <td>Description :</td>
                        <td>{!! $blog->description !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<button type="button" class="btn btn-secondary" data-dismiss="modal" style="float: right;">{{ __('Close')}}</button>