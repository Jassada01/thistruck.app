<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<title>Mass Logistic 1.0</title>
	<meta charset="utf-8" />
	<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
	<meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
	<meta property="og:url" content="https://keenthemes.com/metronic" />
	<meta property="og:site_name" content="Keenthemes | Metronic" />
	<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
	<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-body">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Authentication - Sign-in -->
		<div class="d-flex flex-column flex-lg-row flex-column-fluid">
			<!--begin::Aside-->
			<div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative" style="background-color: #F2C98A">
				<!--begin::Wrapper-->
				<div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
					<!--begin::Content-->
					<div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
						<!--begin::Logo-->
						<a class="py-9 mb-5">
							<img alt="Logo" src="assets/media/logos/logo-2.svg" class="h-60px" />
						</a>
						<!--end::Logo-->
						<!--begin::Title-->
						<h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #986923;">ยินดีต้อนรับเข้าสู่ Mass Logistic</h1>
						<!--end::Title-->
						<!--begin::Description-->
						<p class="fw-bold fs-2 text-muted" style="color: #986923;"> Version 1.0
						</p>
						<!--end::Description-->
					</div>
					<!--end::Content-->
					<!--begin::Illustration-->
					<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style='background-image: url(assets/media/illustrations/unitedpalms-1/13.png)'></div>
					<!--end::Illustration-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Aside-->
			<!--begin::Body-->
			<div class="d-flex flex-column flex-lg-row-fluid py-10">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid">
					<!--begin::Wrapper-->
					<div class="w-lg-500px p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<!--begin::Alert-->
						<div class="alert alert-danger" id="error_alert_box" style="display:none">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column">
									<!--begin::Content-->
									<span> <i class="fas fa-lock text-danger"></i> ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง</span>
									<!--end::Content-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--begin::Actions-->
						<form class="form w-100" novalidate="novalidate" id="login_form">
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">ชื่อผู้ใช้งาน</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" name="uid" autocomplete="off" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack mb-2">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-dark fs-6 mb-0">รหัสผ่าน</label>
									<!--end::Label-->
									<!--begin::Link
										<a class="link-primary fs-6 fw-bolder">Forgot Password ?</a>-->
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							
							<div class="text-center">
								<!--begin::Submit button-->
								<button type="button" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label" id="login_btn">เข้าสู่ระบบ</span>
								</button>
								<!--end::Submit button-->
								<!--end::Google link-->
							</div>
							
							<!--end::Alert-->
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
					<!--begin::Links-->
					<div class="d-flex flex-center fw-bold fs-6">
						<spane class="text-muted px-2">Copyright© 2021</span>
					</div>
					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Body-->
		</div>
		<!--end::Authentication - Sign-in-->
	</div>
	<!--end::Main-->
	<!--begin::Javascript-->
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Page Script-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"> </script>
	<script src="assets/js/page_script/login.js"></script>
	<!--end::Page Script-->

	<!--end::Page Custom Javascript-->
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>