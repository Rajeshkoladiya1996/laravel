<!DOCTYPE html>
<html>
	<!-- Head section -->
	 @include('includes.admin.head')
	<body>
		<div id="spinner"></div>
		<!-- Headre section -->
		 @include('includes.admin.header')

		<!-- Sidebar section -->
		@include('includes.admin.sidebar')

		<!-- content section -->
		<div class="body-content ">
			@yield('content')
		</div>	

		<!-- Script section -->
		@include('includes.admin.script')

	</body>
</html>
