<!DOCTYPE html>
<html>
	<!-- Head section -->
	 @include('includes.front.head')
	<body>
		<!-- <div id="spinner"></div> -->
		<!-- Headre section -->
		@include('includes.front.header')

		<!-- content section -->
		@yield('content')
		
		<!-- Footer section -->
		@include('includes.front.footer')

		<!-- Script section -->
		@include('includes.front.script')

	</body>
</html>
