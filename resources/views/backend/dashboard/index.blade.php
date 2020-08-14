@extends('backend.layout.default')
@section('content')
	
	<div class="modal new-template-modal fade" id="NewTemplateModal" tabindex="-1" role="dialog" aria-labelledby="NewTemplateModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">

				<!--Modal Header Section-->

				<div class="modal-header">
					<h3 id="NewTemplateModalTitle">
						New Template
					</h3>
					<a class="close" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times"></i>
					</a>
				</div>

				<!--Modal Body Section-->
				<form id="create_template" method="post" enctype="multipart/form-data">
                @csrf
					<div class="modal-body">
						<div class="body-inner">
							<div class="row">
								<div class="template-box">
									<div class="row">
										<div class="caption">
											<p>
												Template ID
											</p>
										</div>
										<div class="box">
											<div class="input-box primary">
												<input type="text" placeholder="Type Your Text Here" name="template_custom_id" />
											</div>
										</div>
									</div>
								</div>
								<div class="preview-box">
									<div class="row">
										<div class="caption">
											<p>
												Preview
											</p>
										</div>
										<div class="box">
											<div class="submit-box primary">
												<input type="file" name="preview_image" id="preview_image" class="inputfile" data-multiple-caption="{count} files selected" multiple />
												<label for="preview_image"><span></span> <strong><i class="fas fa-upload"></i>Choose a file</strong></label>
											</div>
										</div>
									</div>
								</div>
								<div class="design-box">
									<div class="row">
										<div class="caption">
											<p>
												Design Background
											</p>
										</div>
										<div class="box">
											<div class="submit-box primary">
												<input type="file" name="background_image" id="background_image" class="inputfile" data-multiple-caption="{count} files selected" multiple />
												<label for="background_image"><span></span> <strong><i class="fas fa-upload"></i>Choose a file</strong></label>
											</div>
										</div>
									</div>
								</div>
								<div class="proof-box">
									<div class="row">
										<div class="caption">
											<p>
												Proof Background
											</p>
										</div>
										<div class="box">
											<div class="submit-box primary">
												<input type="file" name="proof_image" id="proof_image" class="inputfile" data-multiple-caption="{count} files selected" multiple />
												<label for="proof_image"><span></span> <strong><i class="fas fa-upload"></i>Choose a file</strong></label>
											</div>
										</div>
									</div>
								</div>
								<div class="template-box">
									<div class="row">
										<div class="caption">
											<p>
												Select Mapping
											</p>
										</div>
										<div class="box">
											<div class="select-box primary">
												<select name="mapping_id" class="custom-select-box sources" placeholder="{{isset($mappings[0]) && $mappings[0]->product_name ? $mappings[0]->product_name : ''}}" required>
													@foreach($mappings as $index => $mapping)
													@if($index == 0)
													<option value="{{$mapping->id}}" selected>{{$mapping->product_name}}</option>
													@else
													<option value="{{$mapping->id}}" >{{$mapping->product_name}}</option>
													@endif
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="template-box">
									<div class="row">
										<div class="caption">
											<p>
												Select Default Font
											</p>
										</div>
										<div class="box">
											<div class="select-box primary">
												<select class="custom-select-box sources" name="font_id"  placeholder="{{$fonts[0]->edited_name}}" required>
													@foreach($fonts as $index => $font)
													@if($index == 0)
													<option value="{{$font->id}}" selected>{{$font->edited_name}}</option>
													@else
													<option value="{{$font->id}}">{{$font->edited_name}}</option>
													@endif
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="template-box">
									<div class="row">
										<div class="caption">
											<p>
												Font Size
											</p>
										</div>
										<div class="box">
											<div class="select-box primary">
												<select name="font_size" class="custom-select-box sources" placeholder="12px">
													<option value="12px" selected>12px</option>
													<option value="16px">16px</option>
													<option value="21px">21px</option>
													<option value="24px">24px</option>
													<option value="36px">36px</option>
													<option value="48px">48px</option>
													<option value="60px">60px</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="template-box">
									<div class="row">
										<div class="caption">
											<p>
												Text Position
											</p>
										</div>
										<div class="box">
											<div class="select-box primary">
												<select name="text_position" class="custom-select-box sources" placeholder="Left">
													<option value="left" selected>Left</option>
													<option value="center">Center</option>
													<option value="right">Right</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="template-box">
									<div class="row">
										<div class="caption">
											<p>
												Font Colour
											</p>
										</div>
										<div class="box">
											<div class="select-box primary">
												<select name="font_color" class="custom-select-box sources" placeholder="White">
													<option value="white" selected>White</option>
													<option value="black">Black</option>
													<option value="blue">Blue</option>
													<option value="red">Red</option>
													<option value="orange">Orange</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!--Modal Footer Section-->

					<div class="modal-footer">
						<div class="footer-button">
							<div class="row">
								<div class="button">
									<input type="submit" class="btn btn-block btn-add-modal"></input>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Page Content -->

	<div class="page dashboard-main-page toggled">

		<!--Table Section-->

		<div class="section table">
			<div class="container-fluid">
				<div class="row">

					<!--Table Header Section-->

					<div class="wrapper-col table-header">
						<div class="row">
							<div class="col-inner">
								<div class="row">
									<div class="header-text">
										<div class="row">
											<div class="title">
												@if(session()->has('error'))
                                                <div class="alert alert-error badge-danger text-center text-danger text-light"> 
                                                    {!! session('error') !!}
                                                </div>
                                                @endif

                                                @if(session()->has('success'))
                                                <div class="alert alert-error badge-info text-center text-info text-light"> 
                                                    {!! session('success') !!}
                                                </div>
                                                @endif
												<h3>
													All Templates
												</h3>
											</div>
										</div>
									</div>        
								</div>
							</div>
						</div>
					</div>

					<!--Table Action Section-->

					<div class="wrapepr-col table-action">
						<div class="row">
							<div class="col-inner">
								<div class="row">
									<div class="action-search">
										<div class="row">
											<div class="search">
												<div class="input-box primary">
													<input type="text" placeholder="Search Template" />
												</div>
											</div>
										</div>
									</div>
									<div class="action-button">
										<div class="row">
											<div class="button">
												<a class="btn btn-block btn-add" data-toggle="modal" data-target="#NewTemplateModal">
													<i class="fas fa-plus"></i>New Template
												</a>
											</div>
										</div>
									</div>
									<div class="action-pagination">
										<div class="row">
											<div class="pagin-text">
												<div class="row">
													<div class="caption">
														<p>
															Show Entries
														</p>
													</div>
												</div>
											</div>
											<div class="pagin-number">
												<nav aria-label="...">
													<ul class="pagination">
														<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">10</a></li>
														<li class="page-item"><a class="page-link" href="#">25</a></li>
														<li class="page-item"><a class="page-link" href="#">50</a></li>
														<li class="page-item"><a class="page-link" href="#">100</a></li>
													</ul>
												</nav>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!--Table Card Section-->

					<div class="wrapper-col table-card">
						<div class="row">
							@if($templates->isEmpty())
                            <div class="col-inner">
                                <h3 class="text-center">No Templates Found. Please add some Templates.</h3>
                            </div>
                            @else
                            @foreach($templates as $index => $template)
							<div class="col-inner" data-id="{{$template->id}}">
								<div class="custom-card primary">
									<div class="row">
										<div class="col">
											<div class="row">
												<div class="image">
													<a class="image-pop-up" href="{{$template->preview_image}}">
														<img src="{{$template->preview_image}}" />
													</a>
												</div>
											</div>
										</div>
										<div class="col">
											<div class="row">
												<div class="caption">
													<p>
														{{$template->template_custom_id}}
													</p>
												</div>
											</div>
										</div>
										<div class="col">
											<div class="row">
												<div class="caption">
													<p>
														{{$mappingsIdMap[$template->mapping_id]->product_name}}
													</p>
												</div>
											</div>
										</div>
										<div class="col">
											<div class="row">
												<div class="image">
													<a class="image-pop-up" href="{{$template->background_image}}">
														<img src="{{$template->background_image}}" />
													</a>
												</div>
											</div>
										</div>
										<div class="col">
											<div class="row">
												<div class="image">
													<a class="image-pop-up" href="{{$template->proof_image}}">
														<img src="{{$template->proof_image}}" />
													</a>
												</div>
											</div>
										</div>
										<div class="col">
											<div class="row">
												<div class="caption">
													<p>
														Default Font
													</p>
												</div>
												<div class="box">
													<div class="select-box primary">
														<select name="sources" id="sources" class="custom-select-box sources defaultFont" placeholder="{{ $fontsIdMap[$template->font_id]->edited_name}}">
															@foreach($fonts as $index => $font)
															@if($index == 0)
															<option value="{{$font->id}}" selected>{{$font->edited_name}}</option>
															@else
															<option value="{{$font->id}}">{{$font->edited_name}}</option>
															@endif
															@endforeach
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="col">
											<div class="row">
												<div class="caption">
													<p>
														Font Size
													</p>
												</div>
												<div class="box">
													<div class="select-box primary">
														<select name="sources" id="sources" class="custom-select-box sources customFontSize" placeholder="{{ucfirst($template->font_size)}}">
															<?php $fontSizes = ['12px', '16px', '21px', '24px', '36px', '48px', '60px']; ?>
															@foreach($fontSizes as $fontSize)
															@if($fontSize== $template->font_size)
															<option value="{{$fontSize}}" selected>{{ucfirst($fontSize)}}</option>
															@else
															<option value="{{$fontSize}}">{{ucfirst($fontSize)}}</option>
															@endif
															@endforeach
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="col">
											<div class="row">
												<div class="caption">
													<p>
														Text Position
													</p>
												</div>
												<div class="box">
													<div class="select-box primary">
														<select name="sources" id="sources" class="custom-select-box sources textPosition" placeholder="{{ucfirst($template->text_position)}}">
															<?php $textPositions = ['left','center', 'right']; ?>
															@foreach($textPositions as $textPosition)
															@if($textPosition == $template->text_position)
															<option value="{{$textPosition}}" selected>{{ucfirst($textPosition)}}</option>
															@else
															<option value="{{$textPosition}}">{{ucfirst($textPosition)}}</option>
															@endif
															@endforeach
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="col">
											<div class="row">
												<div class="caption">
													<p>
														Font Colour
													</p>
												</div>
												<div class="box">
													<div class="select-box primary">
														<select name="sources" id="sources" class="custom-select-box sources fontColor" placeholder="{{ucfirst($template->font_color)}}">
															<?php $fontColors = ['white','black', 'blue', 'red', 'orange']; ?>
															@foreach($fontColors as $fontColor)
															@if($fontColor == $template->font_color)
															<option value="{{$fontColor}}" selected>{{ucfirst($fontColor)}}</option>
															@else
															<option value="{{$fontColor}}">{{ucfirst($fontColor)}}</option>
															@endif
															@endforeach
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="col">
											<div class="row">
												<div class="icon">
													<a class="icon-copy" href="#" data-toggle="tooltip" data-placement="top" title="Duplicate">
														<i class="fas fa-copy"></i>
													</a>
												</div>
												<div class="icon deleteTemplate" id="{{$template->id}}">
													<a class="icon-delete" href="#" data-toggle="tooltip" data-placement="bottom" title="Delete">
														<i class="fas fa-trash"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endforeach
                            @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
        });

        $(document).on("click",".deleteTemplate",function() {
            var id = $(this).attr('id');
            var request = $.ajax({
                url: "{{route('dashboardDeleteTemplate')}}",
                method: "POST",
                data:{ id: id},
                datatype: "json"
            });
            request.done(function(response) {
              window.location.reload();
            });

            request.fail(function(jqXHR, textStatus) {
            });
        });
        $("#create_template").submit(function(e) {
            e.preventDefault();    
            var formData = new FormData(this);
            var request = $.ajax({
                url: "{{route('dashboardCreateTemplate')}}",
                method: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            request.done(function(response) {
                window.location.reload();
            });

            request.fail(function(jqXHR, textStatus) {
            });
        });
        
         $(document).on("change",".fontColor",function() {
            var id = $(this).parents().find('col-inner').data('id');
            console.log(id, $(this).val());
            return ;
            var request = $.ajax({
               
                method: "POST",
                data:{ id: id},
                datatype: "json"
            });
            request.done(function(response) {
              window.location.reload();
            });

            request.fail(function(jqXHR, textStatus) {
            });
        });
    });
</script>
@endsection