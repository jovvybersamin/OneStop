@extends('cp.layout')

@section('content')
	<video-category-form inline-template v-cloak>
		<form class="" role="form">
			<input type="hidden" name="id" id="id" v-model="form.category.data.id">
			<div class="card" v-if="formReady">
				<div class="head">
					<h1>@{{ headerTitle }}</h1>
					<button type="submit" class="btn btn-primary" @click.prevent="save" :disabled="form.category.busy">
						<span v-if="form.category.busy">
							<i class="fa fa fa-spinner fa-spin fa-fw"></i>
							Saving
						</span>
						<span v-else>
							Save
						</span>
					</button>
				</div>

				<hr>

				<div class="row">
					<div class="col-md-12 col-lg-12">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" class="form-control" id="name" v-model="form.category.data.name">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 col-lg-12">
						<div class="form-group">
							<label for="name">Description</label>
							<input type="textarea" name="name" class="form-control" id="name" v-model="form.category.data.description">
						</div>
					</div>
				</div>
			</div>



		</form>
	</video-category-form>
@stop
