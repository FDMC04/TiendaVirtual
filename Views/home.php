<?php   
  headerTienda($data); 

  $arrSlider = $data['slider'];
  $arrBanner = $data['banner'];
  $arrProductos = $data['productos'];
?>
<!-- Sidebar -->
<aside class="wrap-sidebar js-sidebar">
	<div class="s-full js-hide-sidebar"></div>

	<div class="sidebar flex-col-l p-t-22 p-b-25">
		<div class="flex-r w-full p-b-30 p-r-27">
			<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-sidebar">
				<i class="zmdi zmdi-close"></i>
			</div>
		</div>

		<div class="sidebar-content flex-w w-full p-lr-65 js-pscroll">
			<ul class="sidebar-link w-full">
				<li class="p-b-13">
					<p>Bienvenido: Francisco</p>
				</li>
				<li class="p-b-13">
					<a href="<?= base_url(); ?>" class="stext-102 cl2 hov-cl1 trans-04">
						Inicio
					</a>
				</li>

				<li class="p-b-13">
					<a href="<?= base_url(); ?>/tienda" class="stext-102 cl2 hov-cl1 trans-04">
						Tienda
					</a>
				</li>

				<!-- <li class="p-b-13">
					<a href="#" class="stext-102 cl2 hov-cl1 trans-04">
						Mi cuenta
					</a>
				</li> -->

				<li class="p-b-13">
					<a href="<?= base_url(); ?>/nosotros" class="stext-102 cl2 hov-cl1 trans-04">
						Nosotros
					</a>
				</li>

				<li class="p-b-13">
					<a href="<?= base_url(); ?>/contacto" class="stext-102 cl2 hov-cl1 trans-04">
						Contacto
					</a>
				</li>

				<!-- <li class="p-b-13">
					<a href="#" class="stext-102 cl2 hov-cl1 trans-04">
						Help & FAQs
					</a>
				</li> -->

				<!-- <li class="p-b-13">
					<a href="#" class="stext-102 cl2 hov-cl1 trans-04">
						Salir
					</a>
				</li> -->
			</ul>

			<div class="sidebar-gallery w-full p-tb-30">
				<span class="mtext-101 cl5">
					@ CozaStore
				</span>

				<div class="flex-w flex-sb p-t-36 gallery-lb">
					<!-- item gallery sidebar -->
					<div class="wrap-item-gallery m-b-10">
						<a class="item-gallery bg-img1" href="<?=media()?>/tienda/images/gallery-01.jpg" data-lightbox="gallery" 
						style="background-image: url('<?=media()?>/tienda/images/gallery-01.jpg');"></a>
					</div>

					<!-- item gallery sidebar -->
					<div class="wrap-item-gallery m-b-10">
						<a class="item-gallery bg-img1" href="<?=media()?>/tienda/images/gallery-02.jpg" data-lightbox="gallery" 
						style="background-image: url('<?=media()?>/tienda/images/gallery-02.jpg');"></a>
					</div>

					<!-- item gallery sidebar -->
					<div class="wrap-item-gallery m-b-10">
						<a class="item-gallery bg-img1" href="<?=media()?>/tienda/images/gallery-03.jpg" data-lightbox="gallery" 
						style="background-image: url('<?=media()?>/tienda/images/gallery-03.jpg');"></a>
					</div>

					<!-- item gallery sidebar -->
					<div class="wrap-item-gallery m-b-10">
						<a class="item-gallery bg-img1" href="<?=media()?>/tienda/images/gallery-04.jpg" data-lightbox="gallery" 
						style="background-image: url('<?=media()?>/tienda/images/gallery-04.jpg');"></a>
					</div>

					<!-- item gallery sidebar -->
					<div class="wrap-item-gallery m-b-10">
						<a class="item-gallery bg-img1" href="<?=media()?>/tienda/images/gallery-05.jpg" data-lightbox="gallery" 
						style="background-image: url('<?=media()?>/tienda/images/gallery-05.jpg');"></a>
					</div>

					<!-- item gallery sidebar -->
					<div class="wrap-item-gallery m-b-10">
						<a class="item-gallery bg-img1" href="<?=media()?>/tienda/images/gallery-06.jpg" data-lightbox="gallery" 
						style="background-image: url('<?=media()?>/tienda/images/gallery-06.jpg');"></a>
					</div>

					<!-- item gallery sidebar -->
					<div class="wrap-item-gallery m-b-10">
						<a class="item-gallery bg-img1" href="<?=media()?>/tienda/images/gallery-07.jpg" data-lightbox="gallery" 
						style="background-image: url('<?=media()?>/tienda/images/gallery-07.jpg');"></a>
					</div>

					<!-- item gallery sidebar -->
					<div class="wrap-item-gallery m-b-10">
						<a class="item-gallery bg-img1" href="<?=media()?>/tienda/images/gallery-08.jpg" data-lightbox="gallery" 
						style="background-image: url('<?=media()?>/tienda/images/gallery-08.jpg');"></a>
					</div>

					<!-- item gallery sidebar -->
					<div class="wrap-item-gallery m-b-10">
						<a class="item-gallery bg-img1" href="<?=media()?>/tienda/images/gallery-09.jpg" data-lightbox="gallery" 
						style="background-image: url('<?=media()?>/tienda/images/gallery-09.jpg');"></a>
					</div>
				</div>
			</div>

			<div class="sidebar-gallery w-full">
				<span class="mtext-101 cl5">
					About Us
				</span>

				<p class="stext-108 cl6 p-t-27">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur maximus vulputate hendrerit. Praesent faucibus erat vitae rutrum gravida. Vestibulum tempus mi enim, in molestie sem fermentum quis. 
				</p>
			</div>
		</div>
	</div>
</aside>






<!-- Slider -->
<section class="section-slide">
	<div class="wrap-slick1 rs2-slick1">
		<div class="slick1">
			<?php  
			for ($i=0; $i < count($arrSlider) ; $i++) { 
				$ruta = $arrSlider[$i]['ruta'];
			?>
			<div class="item-slick1 bg-overlay1" style="background-image: url(<?= $arrSlider[$i]['portada'] ?>);" data-thumb="<?= $arrSlider[$i]['portada'] ?>" data-caption="<?= $arrSlider[$i]['nombre'] ?>">
				<div class="container h-full">
					<div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
						<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
							<span class="ltext-202 txt-center cl0 respon2">
								<?= $arrSlider[$i]['descripcion'] ?>
							</span>
						</div>
							
						<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
							<h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
								<?= $arrSlider[$i]['nombre'] ?>
							</h2>
						</div>
							
						<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
							<a href="<?= base_url().'/tienda/categoria/'.$arrSlider[$i]['idcategoria'].'/'.$ruta; ?>" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Ver Productos
							</a>
						</div>
					</div>
				</div>
			</div>
			<?php  
			}
			?>
		</div>

		<div class="wrap-slick1-dots p-lr-10"></div>
	</div>
</section>


<!-- Banner -->
<div class="sec-banner bg0 p-t-95 p-b-55">
	<div class="container">
		<div class="row">
			<?php 
			for ($j=0; $j < count($arrBanner); $j++) { 
				$ruta = $arrBanner[$j]['ruta'];
				
			?>
			<div class="col-md-6 p-b-30 m-lr-auto">
				<!-- Block1 -->
				<div class="block1 wrap-pic-w">
					<img src="<?= $arrBanner[$j]['portada'] ?>" alt="<?= $arrBanner[$j]['nombre'] ?>">

					<a href="<?= base_url().'/tienda/categoria/'.$arrBanner[$j]['idcategoria'].'/'.$ruta; ?>" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
						<div class="block1-txt-child1 flex-col-l">
							<span class="block1-name ltext-102 trans-04 p-b-8">
								<?= $arrBanner[$j]['nombre'] ?>
							</span>

							<!-- <span class="block1-info stext-102 trans-04">
								New Trend
							</span> -->
						</div>

						<div class="block1-txt-child2 p-b-4 trans-05">
							<div class="block1-link stext-101 cl0 trans-09">
								Ver productos
							</div>
						</div>
					</a>
				</div>
			</div>
			<?php  
			}
			?>

			<!-- <div class="col-md-6 p-b-30 m-lr-auto">
				<div class="block1 wrap-pic-w">
					<img src="<?=media()?>/tienda/images/banner-05.jpg" alt="IMG-BANNER">

					<a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
						<div class="block1-txt-child1 flex-col-l">
							<span class="block1-name ltext-102 trans-04 p-b-8">
								Men
							</span>

							<span class="block1-info stext-102 trans-04">
								New Trend
							</span>
						</div>

						<div class="block1-txt-child2 p-b-4 trans-05">
							<div class="block1-link stext-101 cl0 trans-09">
								Shop Now
							</div>
						</div>
					</a>
				</div>
			</div>

			<div class="col-md-6 col-lg-4 p-b-30 m-lr-auto">
				<div class="block1 wrap-pic-w">
					<img src="<?=media()?>/tienda/images/banner-07.jpg" alt="IMG-BANNER">

					<a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
						<div class="block1-txt-child1 flex-col-l">
							<span class="block1-name ltext-102 trans-04 p-b-8">
								Watches
							</span>

							<span class="block1-info stext-102 trans-04">
								Spring 2018
							</span>
						</div>

						<div class="block1-txt-child2 p-b-4 trans-05">
							<div class="block1-link stext-101 cl0 trans-09">
								Shop Now
							</div>
						</div>
					</a>
				</div>
			</div>

			<div class="col-md-6 col-lg-4 p-b-30 m-lr-auto">
				<div class="block1 wrap-pic-w">
					<img src="<?=media()?>/tienda/images/banner-08.jpg" alt="IMG-BANNER">

					<a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
						<div class="block1-txt-child1 flex-col-l">
							<span class="block1-name ltext-102 trans-04 p-b-8">
								Bags
							</span>

							<span class="block1-info stext-102 trans-04">
								Spring 2018
							</span>
						</div>

						<div class="block1-txt-child2 p-b-4 trans-05">
							<div class="block1-link stext-101 cl0 trans-09">
								Shop Now
							</div>
						</div>
					</a>
				</div>
			</div>

			<div class="col-md-6 col-lg-4 p-b-30 m-lr-auto">
				<div class="block1 wrap-pic-w">
					<img src="<?=media()?>/tienda/images/banner-09.jpg" alt="IMG-BANNER">

					<a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
						<div class="block1-txt-child1 flex-col-l">
							<span class="block1-name ltext-102 trans-04 p-b-8">
								Accessories
							</span>

							<span class="block1-info stext-102 trans-04">
								Spring 2018
							</span>
						</div>

						<div class="block1-txt-child2 p-b-4 trans-05">
							<div class="block1-link stext-101 cl0 trans-09">
								Shop Now
							</div>
						</div>
					</a>
				</div>
			</div> -->
		</div>
	</div>
</div>


<!-- Product -->
<section class="bg0 p-t-23 p-b-130">
	<div class="container">
		<div class="p-b-10">
			<h3 class="ltext-103 cl5">
				Productos Nuevos
			</h3>
		</div>
		<hr>	
		<div class="row isotope-grid">
			<?php  
				for ($p=0; $p < count($arrProductos) ; $p++) { 
					$ruta = $arrProductos[$p]['ruta'];
					if(count($arrProductos[$p]['images']) > 0 ){
						$portada = $arrProductos[$p]['images'][0]['url_image'];
					}else{
						$portada = media().'images/uploads/portada_categoria.png';
					}
			?>
					<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0 label-new" data-label="New">
								<img src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombre'] ?>">
								<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$ruta;  ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
									Ver Producto
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$ruta;  ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										<?= $arrProductos[$p]['nombre'] ?>
									</a>

									<span class="stext-105 cl3">
										<?= SMONEY.formatMoney($arrProductos[$p]['precio']); ?>
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="<?=media()?>/tienda/images/icons/icon-heart-01.png" alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l" src="<?=media()?>/tienda/images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div>
					</div>
			<?php  
				}
			?>

		</div>

		<!-- Pagination -->
		<div class="flex-c-m flex-w w-full p-t-38">
			<a href="#" class="flex-c-m how-pagination1 trans-04 m-all-7 active-pagination1">
				1
			</a>

			<a href="#" class="flex-c-m how-pagination1 trans-04 m-all-7">
				2
			</a>
		</div>
	</div>
</section>

<?php footerTienda($data); ?>