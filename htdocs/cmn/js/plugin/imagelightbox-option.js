// JavaScript Document

$( function()
	{
			// ACTIVITY INDICATOR

		var activityIndicatorOn = function()
			{
				$( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
			},
			activityIndicatorOff = function()
			{
				$( '#imagelightbox-loading' ).remove();
			},


			// OVERLAY

			overlayOn = function()
			{
				$( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
			},
			overlayOff = function()
			{
				$( '#imagelightbox-overlay' ).remove();
			},


			// CLOSE BUTTON

			closeButtonOn = function( instance )
			{
				$( '<button type="button" id="imagelightbox-close" title="Close"></button>' ).appendTo( 'body' ).on( 'click touchend', function(){ $( this ).remove(); instance.quitImageLightbox(); return false; });
				//alert("始まり!");
				var dh = $(document).height();
				$("#container").hide();
				$('body').css({
					'height' : dh + 'px',
				});
			},
			closeButtonOff = function()
			{
				$( '#imagelightbox-close' ).remove();
				//alert("終わり!");
				$("#container").delay(200).fadeIn("slow");
			},


			// CAPTION

			captionOn = function()
			{
				var description = $( 'a[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"] img[alt]:eq(0)' ).attr( 'alt' );
				if( description.length > 0 )
					$( '<div id="imagelightbox-caption">' + description + '</div>' ).appendTo( 'body' );
			},
			captionOff = function()
			{
				$( '#imagelightbox-caption' ).remove();
			},


			// NAVIGATION

			navigationOn = function( instance, selector )
			{
				var images = $( selector );
				if( images.length )
				{
					var nav = $( '<div id="imagelightbox-nav"></div>' );
					for( var i = 0; i < images.length; i++ )
						nav.append( '<button type="button"></button>' );

					nav.appendTo( 'body' );
					nav.on( 'click touchend', function(){ return false; });

					var navItems = nav.find( 'button' );
					navItems.on( 'click touchend', function()
					{
						var $this = $( this );
						if( images.eq( $this.index() ).attr( 'href' ) != $( '#imagelightbox' ).attr( 'src' ) )
							instance.switchImageLightbox( $this.index() );

						navItems.removeClass( 'active' );
						navItems.eq( $this.index() ).addClass( 'active' );

						return false;
					})
					.on( 'touchend', function(){ return false; });
				}
			},
			navigationUpdate = function( selector )
			{
				var items = $( '#imagelightbox-nav button' );
				items.removeClass( 'active' );
				items.eq( $( selector ).filter( '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ).index( selector ) ).addClass( 'active' );
			},
			navigationOff = function()
			{
				$( '#imagelightbox-nav' ).remove();
			},


			// ARROWS

			arrowsOn = function( instance, selector )
			{
				var $arrows = $( '<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"></button>' );

				$arrows.appendTo( 'body' );

				$arrows.on( 'click touchend', function( e )
				{
					e.preventDefault();

					var $this	= $( this ),
						$target	= $( selector + '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ),
						index	= $target.index( selector );

					if( $this.hasClass( 'imagelightbox-arrow-left' ) )
					{
						index = index - 1;
						if( !$( selector ).eq( index ).length )
							index = $( selector ).length;
					}
					else
					{
						index = index + 1;
						if( !$( selector ).eq( index ).length )
							index = 0;
					}

					instance.switchImageLightbox( index );
					return false;
				});
			},
			arrowsOff = function()
			{
				$( '.imagelightbox-arrow' ).remove();
			};


		//	WITH ACTIVITY INDICATION

		$( 'a[data-imagelightbox="a"]' ).imageLightbox(
		{
			onLoadStart:	function() { activityIndicatorOn(); },
			onLoadEnd:		function() { activityIndicatorOff(); },
			onEnd:	 		function() { activityIndicatorOff(); }
		});


		//	WITH OVERLAY & ACTIVITY INDICATION

		$( 'a[data-imagelightbox="b"]' ).imageLightbox(
		{
			onStart: 	 function() { overlayOn(); },
			onEnd:	 	 function() { overlayOff(); activityIndicatorOff(); },
			onLoadStart: function() { activityIndicatorOn(); },
			onLoadEnd:	 function() { activityIndicatorOff(); }
		});


		//	WITH "CLOSE" BUTTON & ACTIVITY INDICATION

		var instanceC = $( 'a[data-imagelightbox="c"]' ).imageLightbox(
		{
			quitOnDocClick:	false,
			onStart:		function() { closeButtonOn( instanceC ); },
			onEnd:			function() { closeButtonOff(); activityIndicatorOff(); },
			onLoadStart: 	function() { activityIndicatorOn(); },
			onLoadEnd:	 	function() { activityIndicatorOff(); }
		});


		//	WITH CAPTION & ACTIVITY INDICATION

		$( 'a[data-imagelightbox="d"]' ).imageLightbox(
		{
			onLoadStart: function() { captionOff(); activityIndicatorOn(); },
			onLoadEnd:	 function() { captionOn(); activityIndicatorOff(); },
			onEnd:		 function() { captionOff(); activityIndicatorOff(); }
		});


		//	WITH ARROWS & ACTIVITY INDICATION

		var selectorG = 'a[data-imagelightbox="g"]';
		var instanceG = $( selectorG ).imageLightbox(
		{
			onStart:		function(){ arrowsOn( instanceG, selectorG ); },
			onEnd:			function(){ arrowsOff(); activityIndicatorOff(); },
			onLoadStart: 	function(){ activityIndicatorOn(); },
			onLoadEnd:	 	function(){ $( '.imagelightbox-arrow' ).css( 'display', 'block' ); activityIndicatorOff(); }
		});


		//	WITH NAVIGATION & ACTIVITY INDICATION

		var selectorE = 'a[data-imagelightbox="e"]';
		var instanceE = $( selectorE ).imageLightbox(
		{
			onStart:	 function() { navigationOn( instanceE, selectorE ); },
			onEnd:		 function() { navigationOff(); activityIndicatorOff(); },
			onLoadStart: function() { activityIndicatorOn(); },
			onLoadEnd:	 function() { navigationUpdate( selectorE ); activityIndicatorOff(); }
		});


		//	ALL COMBINED

		var selectorF = 'a[data-imagelightbox="f"]';
		var instanceF = $( selectorF ).imageLightbox(
		{
			onStart:		function() { overlayOn(); closeButtonOn( instanceF ); arrowsOn( instanceF, selectorF ); },
			onEnd:			function() { overlayOff(); captionOff(); closeButtonOff(); arrowsOff(); activityIndicatorOff(); },
			onLoadStart: 	function() { captionOff(); activityIndicatorOn(); },
			onLoadEnd:	 	function() { captionOn(); activityIndicatorOff(); $( '.imagelightbox-arrow' ).css( 'display', 'block' ); }
		});

	});
