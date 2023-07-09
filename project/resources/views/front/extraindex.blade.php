

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
 


	<!-- main -->
	<!-- <script src="{{asset('assets/front/js/mainextra.js')}}"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
	<script>
			$(".lazy-service",).Lazy({
				scrollDirection: 'vertical',
				effect: "fadeIn",
				effectTime:1000,
				threshold: 0,
				visibleOnly: true,  
				onError: function(element) {
					console.log('error loading ' + element.data('src'));
				}
			});
			$(".lazy",).Lazy({
				scrollDirection: 'vertical',
				effect: "fadeIn",
				effectTime:1000,
				threshold: 0,
				visibleOnly: true,  
				onError: function(element) {
					console.log('error loading ' + element.data('src'));
				}
			});
	
	</script>
