<?php
session_start ();
$id_title_deed = $_SESSION ['title_deed'];

include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/core-apis/DatabaseActions.class.inc.php';
if (! class_exists ( 'TitleDeeds' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/TitleDeeds.class.php';
if (! class_exists ( 'County' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/County.class.php';
if (! class_exists ( 'Wards' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/Wards.class.php';
if (! class_exists ( 'TitleDeedEasements' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/TitleDeedEasements.class.php';
if (! class_exists ( 'TitleDeedNatures' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/TitleDeedNatures.class.php';
if (! class_exists ( 'TitleDeedProprietorship' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/TitleDeedProprietorship.class.php';
if (! class_exists ( 'LandOwners' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/LandOwners.class.php';

$action = "query";
$client = "web_desktop";
$titledeeds = new TitleDeeds ( $action, $client );
$approximate_area = $titledeeds->get_approximate_area ( $id_title_deed );
$area_units = $titledeeds->get_area_units ( $id_title_deed );
$land_owner = $titledeeds->get_land_owner ( $id_title_deed );
$edition = $titledeeds->get_edition ( $id_title_deed );
$opened = $titledeeds->get_opened ( $id_title_deed );
$registration_section = $titledeeds->get_registration_section ( $id_title_deed );
$parcel_number = $titledeeds->get_parcel_number ( $id_title_deed );
$plot_number = $titledeeds->get_plot_number ( $id_title_deed );
$registy_map_sheet_number = $titledeeds->get_registy_map_sheet_number ( $id_title_deed );

?>
<!DOCTYPE html>
<html>
<head>

<!-- Bootstrap Core CSS -->
<link href="bower_components/bootstrap/dist/css/bootstrap.min.css"
	rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="bower_components/metisMenu/dist/metisMenu.min.css"
	rel="stylesheet">

<!-- DataTables CSS -->
<link
	href="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css"
	rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link
	href="bower_components/datatables-responsive/css/dataTables.responsive.css"
	rel="stylesheet">

<!-- Custom CSS -->
<link href="dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="bower_components/font-awesome/css/font-awesome.min.css"
	rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
	<div class="">
		<label>(To be compiled only when the applicant has paid the fee of Sh.
			125)</label> <br /> <label style="align: center">At the date stated
			on the front hereof, the following entries appeared in the register
			relating to the land</label>

		<div class="table">
			<table class="table table-responsive table-bordered table-stripped">
				<thead>
					<tr>
						<td>Edition <?php echo $edition; ?></td>
						<td></td>
					</tr>
					<tr>
						<td>Opened <?php echo $opened; ?></td>
						<td>PART A - PROPERTY SECTION</td>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td>

							<table
								class="table table-responsive table-bordered table-stripped">
								<thead>
									<tr>
										<td>Registration Section</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td> <?php
										$ward_name = (new Wards ( $action, $client ))->get_ward_name ( $registration_section );
										$county_id = (new Wards ( $action, $client ))->get_id_county ( $registration_section );
										$county_name = (new County ( $action, $client ))->get_county_name ( $county_id );
										echo $ward_name . '/' . $county_name;
										?></td>
									</tr>

								</tbody>
							</table>

							<table
								class="table table-responsive table-bordered table-stripped">
								<thead>
									<tr>
										<td>Parcel number</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $parcel_number; ?></td>
									</tr>
								</tbody>
							</table>

							<table
								class="table table-responsive table-bordered table-stripped">
								<thead>
									<tr>
										<td>Plot number</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $plot_number;?></td>
									</tr>
								</tbody>
							</table>

							<table
								class="table table-responsive table-bordered table-stripped">
								<thead>
									<tr>
										<td>Approximate are</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $approximate_area." ".$area_units; ?></td>
									</tr>
								</tbody>
							</table>


							<table
								class="table table-responsive table-bordered table-stripped">
								<thead>
									<tr>
										<td>Registry map sheet number</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $registy_map_sheet_number; ?></td>
									</tr>
								</tbody>
							</table>

						</td>

						<td>
							<table
								class="table table-responsive table-bordered table-stripped">
								<thead>
									<tr>
										<td colspan="2">EASEMENTS, ETC</td>
									</tr>
								</thead>
								<tbody>
								<?php
								
								$easements = new TitleDeedEasements ( $action, $client );
								$easements_info = $easements->query_from_title_deed_easements ( array (
										"id_title_deed" 
								), array (
										$id_title_deed 
								) );
								for($i = 0; $i < count ( $easements_info ); $i ++) {
									$easement = $easements_info [$i] ['title_deed_easement'];
									$posted_date = $easements_info [$i] ['posted_date'];
									echo "<tr> <td>" . $posted_date . " </td><td>" . $easement . " </td> </tr>";
								}
								?>
									
								</tbody>
							</table>

						</td>


						<td>
							<table
								class="table table-responsive table-bordered table-stripped">
								<thead>
									<tr>
										<td colspan="2">NATURE OF TITLE</td>
									</tr>
								</thead>
								<tbody>
									<?php
									
									$natures = new TitleDeedNatures ( $action, $client );
									$natures_info = $natures->query_from_title_deed_natures ( array (
											"id_title_deed" 
									), array (
											$id_title_deed 
									) );
									for($i = 0; $i < count ( $natures_info ); $i ++) {
										$nature = $natures_info [$i] ['title_deed_nature'];
										$posted_date = $natures_info [$i] ['posted_date'];
										echo "<tr> <td>" . $posted_date . " </td><td>" . $easement . " </td> </tr>";
									}
									?>
								</tbody>
							</table>

						</td>

					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="table">
		<table
			class="table table-responsive table-bordered table-responsive table-stripped">
			<thead>
				<tr>
					<td colspan="99">PART B - PROPRIETORSHIOP SECTION</td>
				</tr>
			</thead>

			<tbody>

				<tr>
					<td>ENTRY NO.</td>
					<td>DATE</td>
					<td>NAME OF REGISTERED PROPRIETOR</td>
					<td>ADDRESS AND DESCRIPTION OF REGISTERED PROPRIETOR</td>
					<td>CONSIDERATION AND REMARKS</td>
					<td>SIGNATURE OF REGISTERED PROPRIETOR</td>
				</tr>

				<tr>
					<?php
					$proprietorships = new TitleDeedProprietorship ( $action, $client );
					$proprietorship_info = $proprietorships->query_from_title_deed_proprietorship ( array (
							"id_title_deed" 
					), array (
							$id_title_deed 
					) );
					
					for($i = 0; $i < count ( $proprietorship_info ); $i ++) {
						$id_title_deed = $proprietorship_info [$i] ['id_title_deed'];
						$entry_number = $proprietorship_info [$i] ['entry_number'];
						$posted_date = $proprietorship_info [$i] ['posted_date'];
						$registered_proprietor = $proprietorship_info [$i] ['registered_proprietor'];
						$consideration_and_remarks = $proprietorship_info [$i] ['consideration_and_remarks'];
						
						$id_land_owner = $registered_proprietor;
						$land_owner_address = (new LandOwners ( $action, $client ))->get_address ( $id_land_owner );
						$land_owner_name = (new LandOwners ( $action, $client ))->get_firstname ( $id_land_owner ) . " " . (new LandOwners ( $action, $client ))->get_lastname ( $id_land_owner );
						
						echo "<tr><td>" . $entry_number . "</td><td>" . $posted_date . "</td><td>" . $land_owner_name . "</td><td>" . $land_owner_address . "</td><td>" . $consideration_and_remarks . "</td> <td></td></tr>";
					}
					?>
				</tr>
			</tbody>
		</table>
	</div>
	<script>
window.onload = setInterval(function(){ print(); }, 4000);
	</script>
</body>
</html>
<?php ?>