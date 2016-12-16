<?php
// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

function schema_form() {
	
?>
<style>
#schematool { width: auto; }
#schematool input, #schematool select, #schematool textarea, #schematool .daysgroup, #schematool .time { float: right; }
#schemacode { width: 500px; height: 200px; }
#schematool .days, #schematool .openhour, #schematool .openmin, #schematool .closehour, #schematool .closemin { float: none!important; }
</style>
<?php

if ( isset( $_POST['submit'] ) ) { 

	if ($_REQUEST['logourl'] == '' || $_REQUEST['url'] == '') { 
		if ($_REQUEST['url'] == '') {
			$requrl = '<b><font color="#ff0000">URL is required</font></b><br /><br />';
		}
		if ($_REQUEST['logourl'] == '') {
			$reqlogourl = '<b><font color="#ff0000">Logo URL is required</font></b><br /><br />';
		}
	} else {

		if ($_REQUEST['bustype']) { $bustype = '"@type" : "'.$_REQUEST['bustype'].'",'; }
		if ($_REQUEST['busname']) { $busname = '"name" : "'.$_REQUEST['busname'].'",'; }
		if ($_REQUEST['phone']) { $phone = '"telephone" : "'.$_REQUEST['phone'].'",'; }
		if ($_REQUEST['url']) { $url = '"url" : "'.$_REQUEST['url'].'",'; }
		if ($_REQUEST['logourl']) { $logourl = '"logo" : "'.$_REQUEST['logourl'].'",'; }

		//address
		if ($_REQUEST['staddress']) { $staddress = '"streetAddress" : "'.$_REQUEST['staddress'].'",'; }
		if ($_REQUEST['city']) { $city = '"addressLocality" : "'.$_REQUEST['city'].'",'; }
		if ($_REQUEST['state']) { $state = '"addressRegion" : "'.$_REQUEST['state'].'",'; }
		if ($_REQUEST['zip']) { $zip = '"postalCode" : "'.$_REQUEST['zip'].'",'; }

		if ($staddress != '' || $city != '' || $state != '' || $zip != '') {
			$address = '"address": {
		    "@type": "PostalAddress",'
		    .$staddress
		    .$city
		    .$state
		    .$zip
		    .'},';
		}

		//description
		if ($_REQUEST['descript']) { $descript = '"description" : "'.$_REQUEST['descript'].'",'; }
		
		//business hours
		if ($_REQUEST['daymo']) { $daymo = $_REQUEST['daymo'].','; }
		if ($_REQUEST['daytu']) { $daytu = $_REQUEST['daytu'].','; }
		if ($_REQUEST['daywe']) { $daywe = $_REQUEST['daywe'].','; }
		if ($_REQUEST['dayth']) { $dayth = $_REQUEST['dayth'].','; }
		if ($_REQUEST['dayfr']) { $dayfr = $_REQUEST['dayfr'].','; }
		if ($_REQUEST['daysa']) { $daysa = $_REQUEST['daysa'].','; }
		if ($_REQUEST['daysu']) { $daysu = $_REQUEST['daysu'].','; }
		$openinghours = '"openingHours": "'.$daymo.$daytu.$daywe.$dayth.$dayfr.$daysa.$daysu.'*';
		$openinghours = str_replace(",*", " ", $openinghours);
		if ($_REQUEST['openhour']) { $openhour = $_REQUEST['openhour'].':'; }
		if ($_REQUEST['openmin']) { $openmin = $_REQUEST['openmin'].'-'; }
		if ($_REQUEST['closehour']) { $closehour = $_REQUEST['closehour'].':'; }
		if ($_REQUEST['closemin']) { $closemin = $_REQUEST['closemin']; }
		$openinghours .= $openhour.$openmin.$closehour.$closemin;

		if ($_REQUEST['daymo2']) { $daymo2 = $_REQUEST['daymo2'].','; }
		if ($_REQUEST['daytu2']) { $daytu2 = $_REQUEST['daytu2'].','; }
		if ($_REQUEST['daywe2']) { $daywe2 = $_REQUEST['daywe2'].','; }
		if ($_REQUEST['dayth2']) { $dayth2 = $_REQUEST['dayth2'].','; }
		if ($_REQUEST['dayfr2']) { $dayfr2 = $_REQUEST['dayfr2'].','; }
		if ($_REQUEST['daysa2']) { $daysa2 = $_REQUEST['daysa2'].','; }
		if ($_REQUEST['daysu2']) { $daysu2 = $_REQUEST['daysu2'].','; }
		$openinghours .= ' '.$daymo2.$daytu2.$daywe2.$dayth2.$dayfr2.$daysa2.$daysu2.'*';
		$openinghours = str_replace(",*", " ", $openinghours);
		if ($_REQUEST['openhour2']) { $openhour2 = $_REQUEST['openhour2'].':'; }
		if ($_REQUEST['openmin2']) { $openmin2 = $_REQUEST['openmin2'].'-'; }
		if ($_REQUEST['closehour2']) { $closehour2 = $_REQUEST['closehour2'].':'; }
		if ($_REQUEST['closemin2']) { $closemin2 = $_REQUEST['closemin2']; }
		$openinghours .= $openhour2.$openmin2.$closehour2.$closemin2;

		if ($_REQUEST['daymo3']) { $daymo3 = $_REQUEST['daymo3'].','; }
		if ($_REQUEST['daytu3']) { $daytu3 = $_REQUEST['daytu3'].','; }
		if ($_REQUEST['daywe3']) { $daywe3 = $_REQUEST['daywe3'].','; }
		if ($_REQUEST['dayth3']) { $dayth3 = $_REQUEST['dayth3'].','; }
		if ($_REQUEST['dayfr3']) { $dayfr3 = $_REQUEST['dayfr3'].','; }
		if ($_REQUEST['daysa3']) { $daysa3 = $_REQUEST['daysa3'].','; }
		if ($_REQUEST['daysu3']) { $daysu3 = $_REQUEST['daysu3'].','; }
		$openinghours .= ' '.$daymo3.$daytu3.$daywe3.$dayth3.$dayfr3.$daysa3.$daysu3.'*';
		$openinghours = str_replace(",*", " ", $openinghours);
		if ($_REQUEST['openhour3']) { $openhour3 = $_REQUEST['openhour3'].':'; }
		if ($_REQUEST['openmin3']) { $openmin3 = $_REQUEST['openmin3'].'-'; }
		if ($_REQUEST['closehour3']) { $closehour3 = $_REQUEST['closehour3'].':'; }
		if ($_REQUEST['closemin3']) { $closemin3 = $_REQUEST['closemin3']; }
		$openinghours .= $openhour3.$openmin3.$closehour3.$closemin3;

		if ($_REQUEST['daymo4']) { $daymo4 = $_REQUEST['daymo4'].','; }
		if ($_REQUEST['daytu4']) { $daytu4 = $_REQUEST['daytu4'].','; }
		if ($_REQUEST['daywe4']) { $daywe4 = $_REQUEST['daywe4'].','; }
		if ($_REQUEST['dayth4']) { $dayth4 = $_REQUEST['dayth4'].','; }
		if ($_REQUEST['dayfr4']) { $dayfr4 = $_REQUEST['dayfr4'].','; }
		if ($_REQUEST['daysa4']) { $daysa4 = $_REQUEST['daysa4'].','; }
		if ($_REQUEST['daysu4']) { $daysu4 = $_REQUEST['daysu4'].','; }
		$openinghours .= ' '.$daymo4.$daytu4.$daywe4.$dayth4.$dayfr4.$daysa4.$daysu4.'*';
		$openinghours = str_replace(",*", " ", $openinghours);
		if ($_REQUEST['openhour4']) { $openhour4 = $_REQUEST['openhour4'].':'; }
		if ($_REQUEST['openmin4']) { $openmin4 = $_REQUEST['openmin4'].'-'; }
		if ($_REQUEST['closehour4']) { $closehour4 = $_REQUEST['closehour4'].':'; }
		if ($_REQUEST['closemin4']) { $closemin4 = $_REQUEST['closemin4']; }
		$openinghours .= $openhour4.$openmin4.$closehour4.$closemin4;

		if ($_REQUEST['daymo5']) { $daymo5 = $_REQUEST['daymo5'].','; }
		if ($_REQUEST['daytu5']) { $daytu5 = $_REQUEST['daytu5'].','; }
		if ($_REQUEST['daywe5']) { $daywe5 = $_REQUEST['daywe5'].','; }
		if ($_REQUEST['dayth5']) { $dayth5 = $_REQUEST['dayth5'].','; }
		if ($_REQUEST['dayfr5']) { $dayfr5 = $_REQUEST['dayfr5'].','; }
		if ($_REQUEST['daysa5']) { $daysa5 = $_REQUEST['daysa5'].','; }
		if ($_REQUEST['daysu5']) { $daysu5 = $_REQUEST['daysu5'].','; }
		$openinghours .= ' '.$daymo5.$daytu5.$daywe5.$dayth5.$dayfr5.$daysa5.$daysu5.'*';
		$openinghours = str_replace(",*", " ", $openinghours);
		if ($_REQUEST['openhour5']) { $openhour5 = $_REQUEST['openhour5'].':'; }
		if ($_REQUEST['openmin5']) { $openmin5 = $_REQUEST['openmin5'].'-'; }
		if ($_REQUEST['closehour5']) { $closehour5 = $_REQUEST['closehour5'].':'; }
		if ($_REQUEST['closemin5']) { $closemin5 = $_REQUEST['closemin5']; }
		$openinghours .= $openhour5.$openmin5.$closehour5.$closemin5;	
		
		if ($_REQUEST['daymo6']) { $daymo6 = $_REQUEST['daymo6'].','; }
		if ($_REQUEST['daytu6']) { $daytu6 = $_REQUEST['daytu6'].','; }
		if ($_REQUEST['daywe6']) { $daywe6 = $_REQUEST['daywe6'].','; }
		if ($_REQUEST['dayth6']) { $dayth6 = $_REQUEST['dayth6'].','; }
		if ($_REQUEST['dayfr6']) { $dayfr6 = $_REQUEST['dayfr6'].','; }
		if ($_REQUEST['daysa6']) { $daysa6 = $_REQUEST['daysa6'].','; }
		if ($_REQUEST['daysu6']) { $daysu6 = $_REQUEST['daysu6'].','; }
		$openinghours .= ' '.$daymo6.$daytu6.$daywe6.$dayth6.$dayfr6.$daysa6.$daysu6.'*';
		$openinghours = str_replace(",*", " ", $openinghours);
		if ($_REQUEST['openhour6']) { $openhour6 = $_REQUEST['openhour6'].':'; }
		if ($_REQUEST['openmin6']) { $openmin6 = $_REQUEST['openmin6'].'-'; }
		if ($_REQUEST['closehour6']) { $closehour6 = $_REQUEST['closehour6'].':'; }
		if ($_REQUEST['closemin6']) { $closemin6 = $_REQUEST['closemin6']; }
		$openinghours .= $openhour6.$openmin6.$closehour6.$closemin6;

		if ($_REQUEST['daymo7']) { $daymo7 = $_REQUEST['daymo7'].','; }
		if ($_REQUEST['daytu7']) { $daytu7 = $_REQUEST['daytu7'].','; }
		if ($_REQUEST['daywe7']) { $daywe7 = $_REQUEST['daywe7'].','; }
		if ($_REQUEST['dayth7']) { $dayth7 = $_REQUEST['dayth7'].','; }
		if ($_REQUEST['dayfr7']) { $dayfr7 = $_REQUEST['dayfr7'].','; }
		if ($_REQUEST['daysa7']) { $daysa7 = $_REQUEST['daysa7'].','; }
		if ($_REQUEST['daysu7']) { $daysu7 = $_REQUEST['daysu7'].','; }
		$openinghours .= ' '.$daymo7.$daytu7.$daywe7.$dayth7.$dayfr7.$daysa7.$daysu7.'*';
		$openinghours = str_replace(",*", " ", $openinghours);
		if ($_REQUEST['openhour7']) { $openhour7 = $_REQUEST['openhour7'].':'; }
		if ($_REQUEST['openmin7']) { $openmin7 = $_REQUEST['openmin7'].'-'; }
		if ($_REQUEST['closehour7']) { $closehour7 = $_REQUEST['closehour7'].':'; }
		if ($_REQUEST['closemin7']) { $closemin7 = $_REQUEST['closemin7']; }
		$openinghours .= $openhour7.$openmin7.$closehour7.$closemin7;
					
		$openinghours = str_replace("*", "", $openinghours);					$openinghours = rtrim($openinghours, ' ').'",';
			
		//socials
		if ($_REQUEST['fb']) { $fb = '"'.$_REQUEST['fb'].'",'; }
		if ($_REQUEST['twitter']) { $twit = '"'.$_REQUEST['twitter'].'",'; }
		if ($_REQUEST['google']) { $ggle = '"'.$_REQUEST['google'].'",'; }
		if ($_REQUEST['ig']) { $ig = '"'.$_REQUEST['ig'].'",'; }
		if ($_REQUEST['yt']) { $yt = '"'.$_REQUEST['yt'].'",'; }
		if ($_REQUEST['li']) { $li = '"'.$_REQUEST['li'].'",'; }
		if ($_REQUEST['ms']) { $ms = '"'.$_REQUEST['ms'].'",'; }

		if ($fb != '' || $twit != '' || $ggle != '' || $ig != '' || $yt != '' || $li != '' || $ms != '') {
			$schemasocials = '"sameAs": ['
		    .$fb
		    .$twit
		    .$ggle
		    .$ig
		    .$yt
		    .$li
		    .$mi
		    .']';
		} else {
			$nosocials = 'yes';
		}
		
		$thecode = '
		 <script type="application/ld+json">
		{ 
		  "@context" : "http://schema.org",'. 
		  $bustype.
		  $busname. 
		  $phone.
		  $address.
		  $descript.
		  $url.
		  $logourl.
		  $openinghours.
		  	$schemasocials.'} </script>
		';
		$thecode = str_replace(",]", "]", $thecode);
		$thecode = str_replace(",}", "}", $thecode);

		$codebox = "<textarea id='schemacode' name='schemacode' class='txtfld text'>$thecode</textarea><br /><br >";

	}
}
//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
$schemafulldisplay = $requrl.$reqlogourl.$codebox.'

<form id="schematool" method="POST" action="">

<b>Business Information</b><br />

<span><label class="lbl">Business Type</label></span>
<select name="bustype" id="bustype">
<option value="LocalBusiness">Local Business - (Default)</option>
<option value="Organization">Organization - (For services and home offices)</option>
<option value="AccountingService">Accountant</option>
<option value="MedicalClinic">Acupuncture Clinic</option>
<option value="AutoDealer">Acura Dealer</option>
<option value="HVACBusiness">Air Conditioning Contractor</option>
<option value="HVACBusiness">Air Conditioning Repair Service</option>
<option value="HomeAndConstructionBusiness">Air Duct Cleaning Service</option>
<option value="Physician">Allergist</option>
<option value="ProfessionalService">Alternative Medicine Practitioner</option>
<option value="VeterinaryCare">Animal Hospital</option>
<option value="Store">Antique Store</option>
<option value="Store">Appliance Parts Supplier</option>
<option value="Store">Appliance Store</option>
<option value="Residence">Assisted Living Facility</option>
<option value="Physician">Audiologist</option>
<option value="AutoBodyShop">Auto Body Shop</option>
<option value="AutoRepair">Auto Glass Shop</option>
<option value="InsuranceAgency">Auto Insurance Agency</option>
<option value="AutoPartsStore">Auto Parts Store</option>
<option value="AutoRepair">Auto Repair Shop</option>
<option value="Store">Baby Store</option>
<option value="Bakery">Bakery</option>
<option value="Attorney">Bankruptcy Attorney</option>
<option value="BarOrPub">Bar</option>
<option value="HealthAndBeautyBusiness">Barber Shop</option>
<option value="HomeAndConstructionBusiness">Bathroom Remodeler</option>
<option value="BeautySalon">Beauty Salon</option>
<option value="BedAndBreakfast">Bed & Breakfast</option>
<option value="Store">Bedding Store</option>
<option value="BikeStore">Bicycle Store</option>
<option value="AutoDealer">BMW Dealer</option>
<option value="ProfessionalService">Boat Repair Shop</option>
<option value="TattooParlor">Body Piercing Shop</option>
<option value="BookStore">Book Store</option>
<option value="AccountingService">Bookkeeping Service</option>
<option value="ClothingStore">Boutique</option>
<option value="HomeAndConstructionBusiness">Cabinet Maker</option>
<option value="Store">Cabinet Store</option>
<option value="SportingGoodsStore">Canoe & Kayak Store</option>
<option value="AutoDealer">Car Dealer</option>
<option value="AutoWash">Car Detailing Service</option>
<option value="AutoRental">Car Rental Agency</option>
<option value="Physician">Cardiologist</option>
<option value="HomeAndConstructionBusiness">Carpet Cleaning Service</option>
<option value="HomeAndConstructionBusiness">Carpet Installer</option>
<option value="Store">Carpet Store</option>
<option value="MobilePhoneStore">Cell Phone Store</option>
<option value="AccountingService">Certified Public Accountant</option>
<option value="AutoDealer">Chevrolet Dealer</option>
<option value="ChildCare">Child Care Agency</option>
<option value="MedicalClinic">Child Psychologist</option>
<option value="ClothingStore">Children\'s Clothing Store</option>
<option value="FurnitureStore">Children\'s Furniture Store</option>
<option value="Restaurant">Chinese Restaurant</option>
<option value="MedicalClinic">Chiropractor</option>
<option value="Store">Cigar Shop</option>
<option value="ClothingStore">Clothing Store</option>
<option value="CafeOrCoffeeShop">Coffee Shop</option>
<option value="HobbyShop or http://schema.org/Store">Coin Dealer</option>
<option value="RealEstateAgent">Commercial Real Estate Agency</option>
<option value="ProfessionalService">Computer Repair Service</option>
<option value="ComputerStore">Computer Store</option>
<option value="HomeAndConstructionBusiness">Concrete Contractor</option>
<option value="Residence">Condominium Complex</option>
<option value="Store">Consignment Shop</option>
<option value="GeneralContractor">Construction Company</option>
<option value="GeneralContractor">Contractor</option>
<option value="Dentist">Cosmetic Dentist</option>
<option value="Store">Countertop Store</option>
<option value="SportsClub">Country Club</option>
<option value="HomeAndConstructionBusiness">Crane Rental Agency</option>
<option value="HomeAndConstructionBusiness">Crane Service</option>
<option value="Attorney">Criminal Justice Attorney</option>
<option value="GeneralContractor">Custom Home Builder</option>
<option value="School">Dance School</option>
<option value="ChildCare">Day Care Center</option>
<option value="DaySpa">Day Spa</option>
<option value="HomeAndConstructionBusiness">Deck Builder</option>
<option value="FoodEstablishment">Deli</option>
<option value="Dentist">Dental Implants Periodontist</option>
<option value="Dentist">Dentist</option>
<option value="Physician">Dermatologist</option>
<option value="Attorney">Divorce Attorney</option>
<option value="EntertainmentBusiness">DJ</option>
<option value="AutoDealer">Dodge Dealer</option>
<option value="ProfessionalService">Dog Trainer</option>
<option value="DryCleaningOrLaundry">Dry Cleaner</option>
<option value="HomeAndConstructionBusiness">Dry Wall Contractor</option>
<option value="Store">Dry Wall Supply Store</option>
<option value="HomeAndConstructionBusiness">Dump Truck Service</option>
<option value="HealthAndBeautyBusiness">Ear Piercing Service</option>
<option value="Attorney">Elder Law Attorney</option>
<option value="Electrician">Electrician</option>
<option value="ProfessionalService">Electronics Repair Shop</option>
<option value="ElectronicsStore">Electronics Store</option>
<option value="Physician">Emergency Care Physician</option>
<option value="Physician">Emergency Dental Service</option>
<option value="VeterinaryCare">Emergency Veterinarian Service</option>
<option value="Attorney">Employment Attorney</option>
<option value="Dentist">Endodontist</option>
<option value="EntertainmentBusiness">Entertainer</option>
<option value="EntertainmentBusiness">Entertainment Agency</option>
<option value="HomeAndConstructionBusiness">Equipment Rental Agency</option>
<option value="Attorney">Estate Planning Attorney</option>
<option value="ProfessionalService">Event Planner</option>
<option value="MedicalClinic">Eye Care Center</option>
<option value="ProfessionalService">Family Counselor</option>
<option value="Attorney">Family Law Attorney</option>
<option value="Physician">Family Practice Physician</option>
<option value="HomeAndConstructionBusiness">Fence Contractor</option>
<option value="MedicalClinic">Fertility Clinic</option>
<option value="FinancialService">Financial Consultant</option>
<option value="ProfessionalService">Fire Alarm Supplier</option>
<option value="HomeAndConstructionBusiness">Fire Damage Restoration Service</option>
<option value="HomeAndConstructionBusiness">Flooring Contractor</option>
<option value="Store">Flooring Store</option>
<option value="Florist">Florist</option>
<option value="AutoDealer">Ford Dealer</option>
<option value="EventVenue">Function Room Facility</option>
<option value="FurnitureStore">Furniture Rental Service</option>
<option value="FurnitureStore">Furniture Store</option>
<option value="HomeAndConstructionBusiness">Garage Builder</option>
<option value="HomeAndConstructionBusiness">Garage Door Supplier</option>
<option value="GeneralContractor">General Contractor</option>
<option value="Attorney">General Practice Attorney</option>
<option value="AutoDealer">GMC Dealer</option>
<option value="GolfCourse">Golf Course</option>
<option value="GolfCourse">Golf Resort</option>
<option value="Store">Golf Shop</option>
<option value="ProfessionalService">Graphic Designer</option>
<option value="HomeAndConstructionBusiness">Gutter Cleaning Service</option>
<option value="ExerciseGym">Gym</option>
<option value="HealthAndBeautyBusiness">Hair Removal Service</option>
<option value="HairSalon">Hair Salon</option>
<option value="HardwareStore">Hardware Store</option>
<option value="InsuranceAgency">Health Insurance Agency</option>
<option value="HomeAndConstructionBusiness">Heating Contractor</option>
<option value="HobbyShop">Hobby Shop</option>
<option value="MedicalClinic">Holistic Medicine Practitioner</option>
<option value="GeneralContractor">Home Builder</option>
<option value="ProfessionalService">Home Health Care Service</option>
<option value="HomeGoodsStore">Home Improvement Store</option>
<option value="ProfessionalService">Home Inspector</option>
<option value="InsuranceAgency">Home Insurance Agency</option>
<option value="ElectronicsStore">Home Theater Store</option>
<option value="AutoDealer">Honda Dealer</option>
<option value="Hospital">Hospital</option>
<option value="Hotel">Hotel</option>
<option value="HVACBusiness">HVAC Contractor</option>
<option value="ProfessionalService">Hypnotherapy Service</option>
<option value="AutoDealer">Hyundai Dealer</option>
<option value="Attorney">Immigration Attorney</option>
<option value="AutoDealer">Infiniti Dealer</option>
<option value="LodgingBusiness">Inn</option>
<option value="InsuranceAgency">Insurance Agency</option>
<option value="Attorney">Insurance Attorney</option>
<option value="ProfessionalService">Interior Designer</option>
<option value="AutoDealer">Isuzu Dealer</option>
<option value="Restaurant">Italian Restaurant</option>
<option value="AutoDealer">Jaguar Dealer</option>
<option value="Restaurant">Japanese Restaurant</option>
<option value="AutoDealer">Jeep Dealer</option>
<option value="JewelryStore">Jeweler</option>
<option value="ProfessionalService">Jewelry Repair Service</option>
<option value="JewelryStore">Jewelry Store</option>
<option value="School">Karate School</option>
<option value="AutoDealer">Kia Dealer</option>
<option value="HomeAndConstructionBusiness">Kitchen Remodeler</option>
<option value="ProfessionalService">Landscape Architect</option>
<option value="ProfessionalService">Landscape Designer</option>
<option value="ProfessionalService">Landscape Lighting Designer</option>
<option value="HomeAndConstructionBusiness">Landscaper</option>
<option value="GardenStore">Landscaping Supply Store</option>
<option value="HealthAndBeautyBusiness">Laser Hair Removal Service</option>
<option value="Physician">LASIK Surgeon</option>
<option value="ProfessionalService">Lawn Care Service</option>
<option value="Attorney">Lawyer</option>
<option value="AutoDealer">Lexus Dealer</option>
<option value="InsuranceAgency">Life Insurance Agency</option>
<option value="Store">Lighting Store</option>
<option value="ProfessionalService">Limousine Service</option>
<option value="AutoDealer">Lincoln Mercury Dealer</option>
<option value="LiquorStore">Liquor Store</option>
<option value="FinancialService">Loan Agency</option>
<option value="Locksmith">Locksmith</option>
<option value="NightClub">Lounge</option>
<option value="Hotel">Luxury Hotel</option>
<option value="EntertainmentBusiness">Magician</option>
<option value="HomeAndConstructionBusiness">Marble Contractor</option>
<option value="Store">Marble Supplier</option>
<option value="ProfessionalService">Marketing Consultant</option>
<option value="ProfessionalService">Marriage Counselor</option>
<option value="School">Martial Arts School</option>
<option value="HomeAndConstructionBusiness">Masonry Contractor</option>
<option value="HealthAndBeautyBusiness">Massage Therapist</option>
<option value="ClothingStore">Maternity Store</option>
<option value="AutoDealer">Mazda Dealer</option>
<option value="MedicalClinic">Medical Spa</option>
<option value="ProfessionalService">Meeting Planning Service</option>
<option value="MensClothingStore">Men\'s Clothing Store</option>
<option value="MedicalClinic">Mental Health Clinic</option>
<option value="ProfessionalService">Mental Health Service</option>
<option value="AutoDealer">Mercedes Benz Dealer</option>
<option value="Restaurant">Mexican Restaurant</option>
<option value="Restaurant">Middle Eastern Restaurant</option>
<option value="GolfCourse">Miniature Golf Course</option>
<option value="AutoDealer">Mitsubishi Dealer</option>
<option value="FinancialService">Mortgage Broker</option>
<option value="FinancialService">Mortgage Lender</option>
<option value="Motel">Motel</option>
<option value="MotorcycleDealer">Motorcycle Dealer</option>
<option value="InsuranceAgency">Motorcycle Insurance Agency</option>
<option value="Store">Motorcycle Parts Store</option>
<option value="MotorcycleRepair">Motorcycle Repair Shop</option>
<option value="MotorcycleDealer">Motorcycle Shop</option>
<option value="Store">Motorsports Store</option>
<option value="LodgingBusiness">Mountain Cabin</option>
<option value="MovingCompany">Moving & Storage Service</option>
<option value="MovingCompany">Moving Company</option>
<option value="AutoRepair">Muffler Shop</option>
<option value="ProfessionalService">Music Instructor</option>
<option value="School">Music School</option>
<option value="ProfessionalService">Musical Instrument Repair Shop</option>
<option value="MusicStore">Musical Instrument Store</option>
<option value="EntertainmentBusiness">Musician</option>
<option value="NailSalon">Nail Salon</option>
<option value="Physician">Naturopathic Practitioner</option>
<option value="Physician">Neurologist</option>
<option value="NightClub">Night Club</option>
<option value="AutoDealer">Nissan Dealer</option>
<option value="Notary">Notary Public</option>
<option value="ProfessionalService">Nursing Agency</option>
<option value="Residence">Nursing Home</option>
<option value="ProfessionalService">Nutritionist</option>
<option value="Physician">Obstetrician-Gynecologist</option>
<option value="FurnitureStore">Office Furniture Store</option>
<option value="ProfessionalService">Office Space Rental Agency</option>
<option value="OfficeEquipmentStore">Office Supply Store</option>
<option value="AutoDealer">Oldsmobile Dealer</option>
<option value="Optician">Optician</option>
<option value="MedicalClinic">Optometrist</option>
<option value="Physician">Oral Surgeon</option>
<option value="Store">Oriental Rug Store</option>
<option value="Physician">Orthodontist</option>
<option value="Store">Paint Store</option>
<option value="EntertainmentBusiness">Paintball Center</option>
<option value="HousePainter">Painter</option>
<option value="EntertainmentBusiness">Party Planner</option>
<option value="Store">Party Store</option>
<option value="ProfessionalService">Passport Photo Processor</option>
<option value="HomeAndConstructionBusiness">Paving Contractor</option>
<option value="HomeAndConstructionBusiness">Paving Materials Supplier</option>
<option value="Dentist">Pediatric Dentist</option>
<option value="Physician">Pediatrician</option>
<option value="Physician">Periodontist</option>
<option value="Attorney">Personal Injury Attorney</option>
<option value="HealthAndBeautyBusiness">Personal Trainer</option>
<option value="ProfessionalService">Pest Control Service</option>
<option value="ProfessionalService">Pet Groomer</option>
<option value="ProfessionalService">Pet Sitter</option>
<option value="PetStore">Pet Store</option>
<option value="PetStore">Pet Supply Store</option>
<option value="ProfessionalService">Pet Trainer</option>
<option value="ProfessionalService">Photo Restoration Service</option>
<option value="ProfessionalService">Photographer</option>
<option value="MedicalClinic">Physical Therapy Clinic</option>
<option value="ProfessionalService">Piano Instructor</option>
<option value="ProfessionalService">Piano Repair Service</option>
<option value="Store">Piano Store</option>
<option value="HealthAndBeautyBusiness">Pilates Studio</option>
<option value="Restaurant">Pizza Restaurant</option>
<option value="GardenStore">Plant Nursery</option>
<option value="Physician">Plastic Surgeon</option>
<option value="Store">Playground Equipment Supplier</option>
<option value="Plumber">Plumber</option>
<option value="Store">Plumbing Supply Store</option>
<option value="Store">Plywood Supplier</option>
<option value="Physician">Podiatrist</option>
<option value="ProfessionalService">Pool Cleaning Service</option>
<option value="AutoDealer">Porsche Dealer</option>
<option value="MedicalClinic">Pregnancy Care Center</option>
<option value="ProfessionalService">Printer Repair Service</option>
<option value="ProfessionalService">Private Investigator</option>
<option value="Physician">Psychiatrist</option>
<option value="ProfessionalService">Psychologist</option>
<option value="ProfessionalService">Psychotherapist</option>
<option value="BarOrPub">Pub</option>
<option value="RealEstateAgent">Real Estate Agency</option>
<option value="Attorney">Real Estate Attorney</option>
<option value="ProfessionalService">Real Estate Consultant</option>
<option value="ProfessionalService">Reiki Therapist</option>
<option value="Restaurant">Restaurant</option>
<option value="ExerciseGym">Rock Climbing Gym</option>
<option value="HomeAndConstructionBusiness">Rock Landscaping Contractor</option>
<option value="RoofingContractor">Roofing Contractor</option>
<option value="HomeGoodsStore">Rug Store</option>
<option value="RVPark">RV Park</option>
<option value="ProfessionalService">Screen Repair Service</option>
<option value="SelfStorage">Self-Storage Facility</option>
<option value="ProfessionalService">Shoe Repair Shop</option>
<option value="ShoeStore">Shoe Store</option>
<option value="HomeAndConstructionBusiness">Siding Contractor</option>
<option value="HomeAndConstructionBusiness">Sign Shop</option>
<option value="SkiResort">Ski Resort</option>
<option value="Store">Ski Shop</option>
<option value="HealthAndBeautyBusiness">Skin Care Clinic</option>
<option value="HomeAndConstructionBusiness">Snow Removal Service</option>
<option value="DaySpa">Spa</option>
<option value="BarOrPub">Sports Bar</option>
<option value="ProfessionalService">Stereo Repair Service</option>
<option value="ElectronicsStore">Stereo Store</option>
<option value="AutoDealer">Subaru Dealer</option>
<option value="HomeAndConstructionBusiness">Sunroom Contractor</option>
<option value="Physician">Surgeon</option>
<option value="Restaurant">Sushi Restaurant</option>
<option value="AutoDealer">Suzuki Dealer</option>
<option value="HomeAndConstructionBusiness">Swimming Pool Contractor</option>
<option value="HomeAndConstructionBusiness">Swimming Pool Repair Service</option>
<option value="Store">Swimming Pool Supply Store</option>
<option value="ProfessionalService">Tailor</option>
<option value="HealthAndBeautyBusiness">Tanning Salon</option>
<option value="TattooParlor">Tattoo Shop</option>
<option value="Attorney">Tax Attorney</option>
<option value="Taxi">Taxi Service</option>
<option value="TennisComplex">Tennis Club</option>
<option value="Restaurant">Thai Restaurant</option>
<option value="WholesaleStore">Thrift Store</option>
<option value="HomeAndConstructionBusiness">Tile Contractor</option>
<option value="Store">Tile Store</option>
<option value="TireShop">Tire Shop</option>
<option value="Store">Tobacco Shop</option>
<option value="ProfessionalService">Tool Repair Shop</option>
<option value="HardwareStore">Tool Store</option>
<option value="TravelAgency">Tour Agency</option>
<option value="ToyStore">Toy Store</option>
<option value="AutoDealer">Toyota Dealer</option>
<option value="AutoRepair">Transmission Shop</option>
<option value="TravelAgency">Travel Agency</option>
<option value="HomeAndConstructionBusiness">Tree Service</option>
<option value="ProfessionalService">Tutoring Service</option>
<option value="MensClothingStore">Tuxedo Shop</option>
<option value="ProfessionalService">Upholstery Cleaning Service</option>
<option value="EmergencyService">Urgent Care Facility</option>
<option value="Physician">Urologist</option>
<option value="ProfessionalService">Vacuum Cleaner Repair Shop</option>
<option value="Store">Vacuum Cleaner Store</option>
<option value="AutoRental">Van Rental Agency</option>
<option value="Restaurant">Vegan Restaurant</option>
<option value="Restaurant">Vegetarian Restaurant</option>
<option value="VeterinaryCare">Veterinarian</option>
<option value="VeterinaryCare">Veterinary Care</option>
<option value="ProfessionalService">Video Equipment Repair Service</option>
<option value="ClothingStore">Vintage Clothing Store</option>
<option value="Store">Vitamin & Supplements Store</option>
<option value="AutoDealer">Volkswagen Dealer</option>
<option value="AutoDealer">Volvo Dealer</option>
<option value="ProfessionalService">Waste Management Service</option>
<option value="ProfessionalService">Watch Repair Service</option>
<option value="HomeAndConstructionBusiness">Water Damage Restoration Service</option>
<option value="ProfessionalService">Water Testing Service</option>
<option value="HealthAndBeautyBusiness">Waxing Hair Removal Service</option>
<option value="Bakery">Wedding Bakery</option>
<option value="ProfessionalService">Wedding Photographer</option>
<option value="ProfessionalService">Wedding Planner</option>
<option value="Store">Wedding Store</option>
<option value="EventVenue">Wedding Venue</option>
<option value="HealthAndBeautyBusiness">Weight Loss Service</option>
<option value="HomeAndConstructionBusiness">Window Cleaning Service</option>
<option value="HomeAndConstructionBusiness">Window Installation Service</option>
<option value="Store">Window Supplier</option>
<option value="ProfessionalService">Window Tinting Service</option>
<option value="BarOrPub">Wine Bar</option>
<option value="Winery">Winery</option>
<option value="ClothingStore">Women\'s Clothing Store</option>
<option value="MedicalClinic">Women\'s Health Clinic</option>
<option value="HomeAndConstructionBusiness">Wood Floor Installation Service</option>
<option value="HomeAndConstructionBusiness">Wood Floor Refinishing Service</option>
<option value="HomeAndConstructionBusiness">Woodworker</option>
<option value="Store">Woodworking Supply Store</option>
<option value="HealthAndBeautyBusiness">Yoga Studio</option>
</select><br /><br />
<span><label class="lbl">Business Name </label></span><input id="busname" name="busname" class="inputfld text" value="'.$_REQUEST['busname'].'" /><br /><br />
<span><label class="lbl">Phone </label></span><input id="phone" name="phone" class="inputfld text" value="'.$_REQUEST['phone'].'" /><br />(must be in xxx-xxx-xxxx format)<br /><br />
<span><label class="lbl">Street Address </label></span><input id="staddress" name="staddress" class="inputfld text" value="'.$_REQUEST['staddress'].'" /><br /><br />
<span><label class="lbl">City </label></span><input id="city" name="city" class="inputfld text" value="'.$_REQUEST['city'].'" /><br /><br />
<span><label class="lbl">State </label></span><input id="state" name="state" class="inputfld text" value="'.$_REQUEST['state'].'" /><br /><br />
<span><label class="lbl">ZipCode </label></span><input id="zip" name="zip" class="inputfld text" value="'.$_REQUEST['zip'].'" /><br /><br />
<span><label class="lbl">URL <font color="#ff0000">* Required</font> </label></span><input id="url" name="url" class="inputfld text" value="'.$_REQUEST['url'].'" /><br /><br />
<span><label class="lbl">Logo URL <font color="#ff0000">* Required</font> </label></span><input id="logourl" name="logourl" class="inputfld text" value="'.$_REQUEST['logourl'].'" /><br /><br />
<span><label class="lbl">Description </label></span><textarea id="descript" name="descript" class="inputfld text">'.$_REQUEST['descript'].'</textarea><br /><br />
<br /><br />

<b>Business Hours</b><br />
If hours vary on any days, set the days with the same hours in each section.<br />Leave any unneeded sections blank.<br />
<span><label class="lbl">Days</label></span>
<div class="daysgroup"><input name="daymo" type="checkbox" value="Mo" class="days" />Mo <input name="daytu" type="checkbox" value="Tu" class="days" />Tu <input name="daywe" type="checkbox" value="We" class="days" />We <input name="dayth" type="checkbox" value="Th" class="days" />Th <input name="dayfr" type="checkbox" value="Fr" class="days" />Fr <input name="daysa" type="checkbox" value="Sa" class="days" />Sa <input name="daysu" type="checkbox" value="Su" class="days" />Su</div>
<br />
<span><label class="lbl">Opening Time</label></span>
<div class="time"><select name="openhour" class="openhour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="openmin" class="openmin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br />
<span><label class="lbl">Closing Time</label></span>
<div class="time"><select name="closehour" class="closehour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="closemin" class="closemin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br /><br />

<span><label class="lbl">Days</label></span>
<div class="daysgroup"><input name="daymo2" type="checkbox" value="Mo" class="days" />Mo <input name="daytu2" type="checkbox" value="Tu" class="days" />Tu <input name="daywe2" type="checkbox" value="We" class="days" />We <input name="dayth2" type="checkbox" value="Th" class="days" />Th <input name="dayfr2" type="checkbox" value="Fr" class="days" />Fr <input name="daysa2" type="checkbox" value="Sa" class="days" />Sa <input name="daysu2" type="checkbox" value="Su" class="days" />Su</div>
<br />
<span><label class="lbl">Opening Time</label></span>
<div class="time"><select name="openhour2" class="openhour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="openmin2" class="openmin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br />
<span><label class="lbl">Closing Time</label></span>
<div class="time"><select name="closehour2" class="closehour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="closemin2" class="closemin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br /><br />

<span><label class="lbl">Days</label></span>
<div class="daysgroup"><input name="daymo3" type="checkbox" value="Mo" class="days" />Mo <input name="daytu3" type="checkbox" value="Tu" class="days" />Tu <input name="daywe3" type="checkbox" value="We" class="days" />We <input name="dayth3" type="checkbox" value="Th" class="days" />Th <input name="dayfr3" type="checkbox" value="Fr" class="days" />Fr <input name="daysa3" type="checkbox" value="Sa" class="days" />Sa <input name="daysu3" type="checkbox" value="Su" class="days" />Su</div>
<br />
<span><label class="lbl">Opening Time</label></span>
<div class="time"><select name="openhour3" class="openhour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="openmin3" class="openmin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br />
<span><label class="lbl">Closing Time</label></span>
<div class="time"><select name="closehour3" class="closehour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="closemin3" class="closemin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br /><br />

<span><label class="lbl">Days</label></span>
<div class="daysgroup"><input name="daymo4" type="checkbox" value="Mo" class="days" />Mo <input name="daytu4" type="checkbox" value="Tu" class="days" />Tu <input name="daywe4" type="checkbox" value="We" class="days" />We <input name="dayth4" type="checkbox" value="Th" class="days" />Th <input name="dayfr4" type="checkbox" value="Fr" class="days" />Fr <input name="daysa4" type="checkbox" value="Sa" class="days" />Sa <input name="daysu4" type="checkbox" value="Su" class="days" />Su</div>
<br />
<span><label class="lbl">Opening Time</label></span>
<div class="time"><select name="openhour4" class="openhour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="openmin4" class="openmin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br />
<span><label class="lbl">Closing Time</label></span>
<div class="time"><select name="closehour4" class="closehour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="closemin4" class="closemin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br /><br />

<span><label class="lbl">Days</label></span>
<div class="daysgroup"><input name="daymo5" type="checkbox" value="Mo" class="days" />Mo <input name="daytu5" type="checkbox" value="Tu" class="days" />Tu <input name="daywe5" type="checkbox" value="We" class="days" />We <input name="dayth5" type="checkbox" value="Th" class="days" />Th <input name="dayfr5" type="checkbox" value="Fr" class="days" />Fr <input name="daysa5" type="checkbox" value="Sa" class="days" />Sa <input name="daysu5" type="checkbox" value="Su" class="days" />Su</div>
<br />
<span><label class="lbl">Opening Time</label></span>
<div class="time"><select name="openhour5" class="openhour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="openmin5" class="openmin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br />
<span><label class="lbl">Closing Time</label></span>
<div class="time"><select name="closehour5" class="closehour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="closemin5" class="closemin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br /><br />

<span><label class="lbl">Days</label></span>
<div class="daysgroup"><input name="daymo6" type="checkbox" value="Mo" class="days" />Mo <input name="daytu6" type="checkbox" value="Tu" class="days" />Tu <input name="daywe6" type="checkbox" value="We" class="days" />We <input name="dayth6" type="checkbox" value="Th" class="days" />Th <input name="dayfr6" type="checkbox" value="Fr" class="days" />Fr <input name="daysa6" type="checkbox" value="Sa" class="days" />Sa <input name="daysu6" type="checkbox" value="Su" class="days" />Su</div>
<br />
<span><label class="lbl">Opening Time</label></span>
<div class="time"><select name="openhour6" class="openhour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="openmin6" class="openmin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br />
<span><label class="lbl">Closing Time</label></span>
<div class="time"><select name="closehour6" class="closehour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="closemin6" class="closemin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br /><br />

<span><label class="lbl">Days</label></span>
<div class="daysgroup"><input name="daymo7" type="checkbox" value="Mo" class="days" />Mo <input name="daytu7" type="checkbox" value="Tu" class="days" />Tu <input name="daywe7" type="checkbox" value="We" class="days" />We <input name="dayth7" type="checkbox" value="Th" class="days" />Th <input name="dayfr7" type="checkbox" value="Fr" class="days" />Fr <input name="daysa7" type="checkbox" value="Sa" class="days" />Sa <input name="daysu7" type="checkbox" value="Su" class="days" />Su</div>
<br />
<span><label class="lbl">Opening Time</label></span>
<div class="time"><select name="openhour7" class="openhour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="openmin7" class="openmin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br />
<span><label class="lbl">Closing Time</label></span>
<div class="time"><select name="closehour7" class="closehour">
<option value=""></option><option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option><option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option>
</select>
 : 
<select name="closemin7" class="closemin">
<option value=""></option><option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>
</select>
</div><br /><br />

<b>Social Links</b><br />

<span><label class="lbl">Facebook </label></span><input id="fb" name="fb" class="inputfld text" value="'.$_REQUEST['fb'].'" /><br /><br />
<span><label class="lbl">Twitter </label></span><input id="twitter" name="twitter" class="inputfld text" value="'.$_REQUEST['twitter'].'" /><br /><br />
<span><label class="lbl">Google+ </label></span><input id="google" name="google" class="inputfld text" value="'.$_REQUEST['google'].'" /><br /><br />
<span><label class="lbl">Instagram </label></span><input id="ig" name="ig" class="inputfld text" value="'.$_REQUEST['ig'].'" /><br /><br />
<span><label class="lbl">YouTube </label></span><input id="yt" name="yt" class="inputfld text" value="'.$_REQUEST['yt'].'" /><br /><br />
<span><label class="lbl">LinkedIn </label></span><input id="li" name="li" class="inputfld text" value="'.$_REQUEST['li'].'" /><br /><br />
<span><label class="lbl">Myspace </label></span><input id="ms" name="ms" class="inputfld text" value="'.$_REQUEST['ms'].'" /><br /><br />

<input id="getcode" class="button_text" type="submit" name="submit" value="Submit" /><br /><br />

</form>';

	if(get_option('seo_tools_linkback_seotools') == 'on') {
		$seotools = '<p>&nbsp;</p><small><a href="http://www.seoautomatic.com/unique-tools/structured-data-builder/" target="_blank">This Structured Data Tool for Local Businesses was provided by SEO Automatic</a></small>';
	} else {
		$seotools = '';
	}
	
return $schemafulldisplay.$seotools;

}
	
add_shortcode( 'schematool', 'schema_form' );
?>