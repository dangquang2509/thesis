///////////////////////////////////////////////////////////////
// variables message
///////////////////////////////////////////////////////////////
var locale = "en";
var button_ok = "OK";
var button_cancel = "Cancel";
var NotEntered = "Select Spherical image.";
var FileSizeError = "File size available for posting is 10MB or less.";
var NotJpeg = "This file cannot be posted";
var NotImage = "This file cannot be posted.";
var ZeroByte = "This file cannot be posted.";
var CanNotPost = "The format of the file is incorrect. Please insert jpg file.";
var NoTourTitle = "Input of house title is required.";
var NoFloorMap = "Input of floor plan is required.";
var NoSpheres = "Input of Spherical image is required.";
var NoPlot = "To register a house, it is necessary to plot one or more spherical images on the floor plan.";
var NoLocation = "Input of location is required";
var TourTitleToLong = "Input house title within 255 characters.";
var TourCustomkeyToLong = "Enter custom key within 100 characters";
var DuringAjaxWhenRelease = "Register is not allowed during posting of the floor plan, spherical image, non-tripod image and annotation image.";
var DuringAjaxWhenPreview = "Preview is not allowed during posting of the floor plan, spherical image, non-tripod image and annotation image.";
var DuringAjaxWhenSave = "Temporary save is not allowed during posting of the floor plan, spherical image, non-tripod image and annotation image.";
var MoreThan30Spheres = "31 or more spherical images cannot be registered.";
var OnlyOneFloorMap = "Select one floor plan image.";

var CanNotGetSphere = "The spherical information below cannot be obtained. Spherical ID";
var DuringRestoreWhenRelease = "Register is not allowed while reading data.";
var DuringRestoreWhenPreview = "Preview is not allowed while reading data.";
var DuringRestoreWhenSave = "Temporary save is not allowed while reading data.";

var IllegalTourTitle = "Character not allowed for use is input in House title. (Characters not allowed: < , > , [ , ] )";
var IllegalSphereTitle = "Character not allowed for use is input in Spherical title. (Characters not allowed: < , > , [ , ] )";
var IllegalTourCustomkey = "Input Custom key in half-width alphanumeric characters.";
var ExistTourKey = "Input Custom key already exists";

var TimeoutUploadSphere = "Failed to post param1. Post it again.";
var TimeoutDeleteFloorPlan = "Failed to delete floor plan. Delete it again."
var TimeoutCheckTourKey = "Failed to check tour key exist. Check it again."
var TimeoutCreateUser = "Failed to create the user. Create it again.";
var TimeoutSetTemplete = "Template settings failed. Set it again.";
var TimeoutSaveTourdraft = "Failed to create the temporarily saved data. Create it again.";

var Plot = "marker";
var exist_plot = "A marker already exists.";
var title_not_set = "Image title";
var JAICO0002 = "(If you delete the floor plan, all information including markers and links will be deleted)";
var JAPEE0001 = "三脚以外の画像を掲示している間は更新できません。";

///////////////////////////////////////////////////////////////
// global variables
///////////////////////////////////////////////////////////////
var uploaded_spheres = new Array();
var uploading_counter = 0;
var sphere_spinners = new Map();
var floormap_layer = null;
var plots = [];
var selected_sphere_id = null;
var jsobj_rebuild_queue = [];
var sortSpheres = null;
var linked_plots = new Array();
var out_area_flg = false;
var embed_sphere_id = null;
var hlookat_before = null;
var settings = {};
var annotations = [];
var arc_angle = parseInt('100');
var arc_direction = parseInt('270');
var arc_selected = false;
var floormap_spinner = new Spinner();
var plot_scale;
var error_spheres = new Array();

///////////////////////////////////////////////////////////////
// canvas variables and krpano variable and tour variable
///////////////////////////////////////////////////////////////
//
// krpano variable
var viewer = createPanoViewer({
    swf: "/vtour/tour.swf",
    target: "pano",
    html5: "auto",
    mobilescale: 1.0,
    passQueryParameters: true,
    bgcolor: "#ffffff",
    consolelog: true
});
viewer.addVariable("xml", null);
viewer.embed();
//
// canvas variable
var moveMode = false;
var linkMode = true;
var removeMode = false;
var isDown = false;
$canvas = $("#floor-plan");
$canvas.attr("width", "1px");
$canvas.attr("height", "1px");
var offsetX = $canvas.offset().left;
var offsetY = $canvas.offset().top;
$canvasRound = $(".js-wrap-floor-plan");
var canvas = document.getElementById("floor-plan");
var context = canvas.getContext("2d");
var widthCanvas = 0;
var heightCanvas = 0;
context.strokeStyle = "#15a1b1";
var inCanvas = false;
var startId = '';
var startX = 0;
var startY = 0;
var startMoveX = 0;
var startMoveY = 0;
var startMoveArcX = 0;
var startMoveArcY = 0;
var startMoveText = '';
var startMoveId = '';
var startMoveAngle = 0;
var error = false;
var lineRemove = {};
var rad_before = 0;
var arc_selected = false;
var arcCheck = false;
//var storedLines = [];
var flagNotMove = true;
var storedArc = [];
var pointRelate = [];
var lineRelate = [];
const R_POINT = 16;
//
// tour variable
var CHECK_KBN_UPLOAD_TOUR = 1;
var CHECK_KBN_PREVIEW = 2;

///////////////////////////////////////////////////////////////
// jquery events
///////////////////////////////////////////////////////////////
var duringAjax = false;
$(function($) {
	$(document).ajaxStart(function() {
		duringAjax = true;
	}).ajaxStop(function() {
		duringAjax = false;
	});
});

$(function($) {
	$('.js-drop-spheres').on('dragover', function(e) {
		return false;
	});
	$('.js-drop-spheres').on('dragleave', function(e) {
		return false;
	});
	$('.js-drop-spheres').on('drop', function(e) {
		var files = e.originalEvent.dataTransfer.files;
		uploadSpheres(files);
		return false;
	});
	$(document).on("click", ".uploaded img", function() {
		selectSphere($(this).parent().attr("id"));
		insertViewer($(this).parent().attr("id"));
		return;
	});
	$(document).on("click", ".sphere-close", function() {

		deleteMessage();

		removeUploadedSphere();

		removePlotPoint();

		updateMarkerPlot();

		reDraw();

		setBoxMessage();

		removeKrpanoView();

		selected_sphere_id = null;

		return false;
	});
	$(document).on("change", ".scene-title", function() {
		deleteMessage();

		var uploadedSphere = getUploadedSphere($(this).parent().attr("id"));
		if (uploadedSphere != null) {
			uploadedSphere.title = this.value;
		}

		var sphere_title_check_result = checkIllegalSphereTitle();

		if (sphere_title_check_result != null) {
			insertErrorMessage(get_message(sphere_title_check_result));
		}
	});
	$(".sortable").sortable({
		tolerance: "pointer",
		scrollSensitivity: 1,
		scrollSpeed: 20,
		opacity: 0.7,
		cancel: '.unsortable',
		handle: 'img',
	});
	$('.js-floor-plan').on('dragenter', function(e) {
		$('.js-img-minimap img').addClass("on-area");
		return false;
	});
	$('.js-floor-plan').on('dragleave', function(e) {
		$('.js-img-minimap img').removeClass("on-area");
		return false;
	});

	$('.js-floor-plan').on('drop', function(e, ui) {
		var uploaded_sphere = null;

		if (ui) {
			var id = ui.draggable.attr('id');
			uploaded_sphere = getUploadedSphere(id);
		}

		return false;

	});
	$(".js-floor-plan").droppable({
		over: function(e, ui) {
			$('.js-img-minimap img').addClass("on-area");
			return false;
		},
		out: function(e, ui) {
			$('.js-img-minimap img').removeClass("on-area");
			return false;
		},
		drop: function(e, ui) {
			$('.js-img-minimap img').removeClass("on-area");

			var id = ui.draggable.attr('id');

			var uploaded_sphere = getUploadedSphere(id);

			if (uploaded_sphere == null) {
				return false;
			} else if (!uploaded_sphere.isUploaded) {
				return false;
			}

			if (!$(".js-floor-plan").get(0)) {
				return false;
			}

			if (getPlot(id) != null) {
				deleteMessage();
				insertErrorMessage(exist_plot);
				return false;
			}

			var offset = $(this).offset();
			var x = e.originalEvent.pageX - offset.left;
			var y = e.originalEvent.pageY - offset.top;
			if (x > 10 && y > 10 && x < widthCanvas - 10 && y < heightCanvas - 10) {
				var plot = createPlotInfo(id, x, y);
				storedArc.push({x: plot.x, y: plot.y, startAngle: plot.startAngle, active: false});
				plots.push(plot);
				deleteMessage();
				insertPlotNumber();

				updateMarkerPlot();

				drawPoint(plot, plot.text,'#494949');

				return false;
			}
			//return false;
		}
	});
});

///////////////////////////////////////////////////////////////
// functions upload list image vr
///////////////////////////////////////////////////////////////
//
// open dialog upload minimap and upload image vr
function openFileDialog(id) {
	$('#' + id).click();
	return false;
}

// upload multi file image vr
function uploadSpheres(files) {
	deleteMessage();

	$.each(files, function(i, file) {
		var ret = checkSphereFile(file);
		var message = get_message(ret, file.name);
		if (message != null) {
			insertErrorMessage(message);
		} else {
			loadSphere(file);
		}
	});

	clearFiles("file_spheres");
}

// drag sort position for image 360
$(".sortable").sortable({
	update: function(event, ui) {
		var updated_sphere_id = ui.item.attr('id');
		sortSpheres = $(".sortable").sortable('toArray');

		if (floormap_layer != null) {
			if (getPlot(updated_sphere_id) == null) {
				$(this).sortable("cancel");
				return false;
			}
		}

		if (out_area_flg) {
			return true;
		}

		var replaced_plots = new Array();
		var replaced_uploaded_spheres = new Array();
		for (i in sortSpheres) {
			var sphere_id = sortSpheres[i];
			var plot = getPlot(sphere_id);
			if (plot != null) {
				replaced_plots.push(plot);
			}
			var sphere = getUploadedSphere(sphere_id);
			replaced_uploaded_spheres.push(sphere);
		}

		sortSpheres = null;

		plots = replaced_plots;
		uploaded_spheres = replaced_uploaded_spheres;

		insertPlotNumber();

		updateMarkerPlot();

		reDraw();
	},
	stop: function(event, ui) {
		var id = ui.item.attr("id");
		var plot_index = getPlotIndex(id);
		if(plot_index != null) {
			if(plot_index == 0) {
				$(".js-scroll-area").prepend($("#" + id));
			} else {
				var pre_id = plots[plot_index - 1].id;
				$("#" + pre_id).after($("#" + id));
			}
			sortUploadSpheresList();
		}
		out_area_flg = false;
	},
	out: function(event, ui) {
		out_area_flg = true;
	},
	over: function(event, ui) {
		out_area_flg = false;
	}
});

// delete message toastr
function deleteMessage() {
	toastr.remove();
}

// show or hidden message box drag drop in block image vr
function setBoxMessage() {
	if ($(".js-drop-spheres").children('.js-scroll-area').children('.sphere-item').length > 0) {
		$(".js-drop-spheres").children('.ot-message').css({
			'display': 'none'
		});
	} else {
		$(".js-drop-spheres").children('.ot-message').css({
			'display': 'block'
		});
	}
}

// check file image size upload valid
function checkSphereFile(file) {
	if (IsJpegFile(file) == false) {
		return "CanNotPost";
	}
	if (IsZeroByte(file) == false) {
		return "ZeroByte";
	}
	var limit = 100 * 1024 * 1024;
	if (IsFileMaxSize(file, limit) == false) {
		return "FileSizeError";
	}
}

// check file image type upload valid
function IsJpegFile(file) {
	var fileName = file.name;
	var Extension = getExtension(fileName);

	if (Extension.toLowerCase() === "jpg" || Extension.toLowerCase() === "jpeg") {
		return true;
	} else {
		return false;
	}
}

// check file image extension upload valid
function getExtension(fileName) {
	var ret;
	if (!fileName) {
		return ret;
	}
	var fileTypes = fileName.split(".");
	var len = fileTypes.length;
	if (len === 0) {
		return ret;
	}
	ret = fileTypes[len - 1];
	return ret;
}

// check file image zero size length upload valid
function IsZeroByte(file) {
	var fileSize = file.size;
	if (fileSize != 0) {
		return true;
	}
	return false;
}

// check file image max size length upload valid
function IsFileMaxSize(file, limit) {
	var fileSize = file.size;
	var maxSize = limit;
	if (maxSize == 0) {
		maxSize = 10 * 1024 * 1024;
	}
	if (fileSize <= maxSize) {
		return true;
	}
	return false;
}

// get message error from message variable
function get_message(ret, param) {
	if (ret === "NotEntered") {
		return NotEntered;
	}
	if (ret === "FileSizeError") {
		return FileSizeError;
	}
	if (ret === "NotJpeg") {
		return NotJpeg;
	}
	if (ret === "NotImage") {
		return NotImage;
	}
	if (ret === "ZeroByte") {
		return ZeroByte;
	}
	if (ret === "CanNotPost") {
		return "[" + param + CanNotPost;
	}
	if (ret === "NoTourTitle") {
		return NoTourTitle;
	}
	if (ret === "NoFloorMap") {
		return NoFloorMap;
	}
	if (ret === "NoLocation") {
		return NoLocation;
	}
	if (ret === "NoSpheres") {
		return NoSpheres;
	}
	if (ret === "NoPlot") {
		return NoPlot;
	}
	if (ret === "TourTitleToLong") {
		return TourTitleToLong;
	}
	if (ret === "TourCustomkeyToLong") {
		return TourCustomkeyToLong;
	}
	if (ret === "DuringAjaxWhenRelease") {
		return DuringAjaxWhenRelease;
	}
	if (ret === "DuringAjaxWhenPreview") {
		return DuringAjaxWhenPreview;
	}
	if (ret === "DuringAjaxWhenSave") {
		return DuringAjaxWhenSave;
	}
	if (ret === "MoreThan30Spheres") {
		return MoreThan30Spheres;
	}
	if (ret === "OnlyOneFloorMap") {
		return OnlyOneFloorMap;
	}
	if (ret === "CanNotGetSphere") {
		return CanNotGetSphere + ":" + param;
	}
	if (ret === "DuringRestoreWhenRelease") {
		return DuringRestoreWhenRelease;
	}
	if (ret === "DuringRestoreWhenPreview") {
		return DuringRestoreWhenPreview;
	}
	if (ret === "DuringRestoreWhenSave") {
		return DuringRestoreWhenSave;
	}
	if (ret === "IllegalTourTitle") {
		return IllegalTourTitle;
	}
	if (ret === "IllegalTourCustomkey") {
		return IllegalTourCustomkey;
	}
	if (ret === "ExistTourKey") {
		return ExistTourKey;
	}
	if (ret === "IllegalSphereTitle") {
		return IllegalSphereTitle;
	}
	if (ret === "FailedToUploadFile") {
		var temp_message = TimeoutUploadSphere;
		return temp_message.replace(/param1/g, param);
	}
	if (ret === "FailedToDeleteFile") {
		return TimeoutDeleteFloorPlan;
	}
	if (ret === "FailedToCheckTourKey") {
		return TimeoutCheckTourKey;
	}
	if (ret === "TimeoutCreateUser") {
		return TimeoutCreateUser;
	}
	if (ret === "TimeoutSetTemplete") {
		return TimeoutSetTemplete;
	}
	if (ret === "TimeoutSaveTourdraft") {
		return TimeoutSaveTourdraft;
	}
	if (ret === "JAPEE0001") {
		return JAPEE0001;
	}
	var re = new RegExp(Plot);
	if (String(ret).match(re)) {
		return ret;
	}
	return null;
}

// insert error message to toast popup
function insertErrorMessage(message) {
	toastr["error"](message);
}

// save and load image vr after uploaded
function loadSphere(file) {
	var reader = new FileReader();
	reader.onload = function(e) {
		if ($(".js-scroll-area").children('.sphere-item').length >= 30) {
			insertErrorMessage(get_message("MoreThan30Spheres", ""));
			return false;
		}
		var unique_str = "uploading" + uploading_counter;
		uploading_counter++;
		insertSphere(unique_str, reader.result, "");
		postingSphere(file, unique_str);
	};
	reader.readAsDataURL(file);
}

// insert a image vr in block image vr
function insertSphere(div_id, sphere_source, sphere_title) {
	var div = document.createElement("div");
	div.id = div_id;
	div.setAttribute("class", "sphere-item clearfix unsortable");
	$(".js-scroll-area").append(div);

	var image = new Image();

	image.onload = function() {
		var sphere_div = document.getElementById(div_id);
		if (sphere_div != null) {
			image.setAttribute("class", "equi-thumbnail");

			image.width = 180;
			image.height = 90;

			if (getUploadedSphere(div_id) == null || !getUploadedSphere(div_id).isUploaded) {
				image.draggable = false;
			}

			sphere_div.appendChild(image);

			var scene_title = document.createElement("input");
			scene_title.setAttribute("type", "text");
			scene_title.setAttribute("class", "scene-title border-none");
			scene_title.setAttribute("placeholder", title_not_set);
			scene_title.setAttribute("maxlength", "36");
			scene_title.value = sphere_title;

			var br = document.createElement("br");
			sphere_div.appendChild(br);
			sphere_div.appendChild(scene_title);
		}
	};
	image.src = sphere_source;
}

// get image vr by id in store uploaded images vr
function getUploadedSphere(id) {
	for (i in uploaded_spheres) {
		if (uploaded_spheres[i].id == id) {
			return uploaded_spheres[i];
		}
	}
	return null;
}

// insert image vr in database
function postingSphere(file, indicator_key) {
	var formData = new FormData();
	formData.append('file', file);
	formData.append('counter', uploading_counter);

	var sphere_id;
	var equirectangular_source;
	var thumbnail_source;
	var toursphere_url;

	var spinner = new Spinner().spin(document.getElementById(indicator_key));
	sphere_spinners.set(indicator_key, spinner);

	var uploaded_sphere = createUploadedSphere(indicator_key, "", "", "", "", false);
	uploaded_spheres.push(uploaded_sphere);
	insertPlotNumber();

	jsobj_rebuild_queue.push("true");

	$.ajax('/admincp/house/upload-spherical-photo', {
		method: 'POST',
		contentType: false,
		processData: false,
		data: formData,
		dataType: 'json',
		timeout: 1200000,
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			var error_message = null;
			if (textStatus == "timeout") {
				error_message = get_message("FailedToUploadFile", file.name);
			} else if (XMLHttpRequest.responseJSON) {
				var response_json = XMLHttpRequest.responseJSON;
				if (XMLHttpRequest.status == "401") {
					error_message = (response_json.error);

					//Start login if need
					//End login if need
					return;
				} else {
					error_message = (response_json.error_message);
				}
			} else {
				error_message = get_message("FailedToUploadFile", file.name);
			}
			insertErrorMessage(error_message);

			var sphere_div = document.getElementById(indicator_key);
			sphere_div.parentNode.removeChild(sphere_div);

			removeUploadedSphereById(indicator_key);

			jsobj_rebuild_queue.splice(0, 1);
		},
		success: function(data) {
			sphere_id = (data.sphere_id);
			equirectangular_source = (data.equirectangular_source);
			thumbnail_source = (data.thumbnail_source);
			toursphere_url = (data.toursphere_url);

			var sphere_div = document.getElementById(indicator_key);
			sphere_div.id = sphere_id;

			sphere_div.className += " uploaded";

			$("#" + sphere_id + " img").attr("draggable", true);

			$("#" + sphere_id + " img").attr("src", thumbnail_source);

			$("#" + sphere_id).removeClass("unsortable");

			var title = "";
			if ($("#" + sphere_id + " input").length) {
				title = $("#" + sphere_id + " input").val();
			}

			updateUploadedSphere(indicator_key, sphere_id, title, thumbnail_source, equirectangular_source, toursphere_url, true);

			if (sortSpheres != null) {
				updateSortSphereList(indicator_key, sphere_id);
			}
			jsobj_rebuild_queue.splice(0, 1);
		},
		complete: function(data) {
			var spinner = sphere_spinners.get(indicator_key);

			if (spinner != null) {
				spinner.stop();
			}

			insertPlotNumber();

			setBoxMessage();
		}
	});
}

// create object image element
function createUploadedSphere(id, title, equiThumbnail_source, equirectangular_source, toursphere_url, is_uploaded) {
	var uploaded_sphere = {
		id: id,
		title: title,
		equiThumbnail_uri: equiThumbnail_source,
		equirectangular_uri: equirectangular_source,
		toursphere_uri: toursphere_url,
		telopcontent: "",
		hlookat: "0",
		isUploaded: is_uploaded
	};
	return uploaded_sphere;
}

// insert number position of image vr in block image vr
function insertPlotNumber() {
	$(".plot_number").remove();

	var scene_array;
	var marker_array;
	if (floormap_layer != null) {
		marker_array = plots;
	} else {
		marker_array = uploaded_spheres;
	}

	for (i in marker_array) {
		var marker = marker_array[i];

		var div = document.createElement("div");
		div.setAttribute("class", "plot_number");

		if (marker.id == selected_sphere_id) {
			div.style.backgroundColor = '#029fdc';
		}

		var number = parseInt(i) + 1;

		div.innerHTML = "<p>" + number + "</p>";
		$("#" + marker.id).append(div);

		i++;
	}
}

// remove a image vr in store uploaded image vr
function removeUploadedSphereById(id) {
	for (i in uploaded_spheres) {
		if (uploaded_spheres[i].id == id) {
			uploaded_spheres.splice(i, 1);
		}
	}
}

// update value of object image vr in store uploaded image vr
function updateUploadedSphere(old_id, new_id, title, equiThumbnail_source, equirectangular_source, toursphere_url, is_uploaded) {
	var uploaded_sphere_index = getUploadedSphereIndex(old_id);

	if (uploaded_sphere_index != null) {
		uploaded_spheres[uploaded_sphere_index].id = new_id;
		uploaded_spheres[uploaded_sphere_index].title = title;
		uploaded_spheres[uploaded_sphere_index].equiThumbnail_uri = equiThumbnail_source;
		uploaded_spheres[uploaded_sphere_index].equirectangular_uri = equirectangular_source;
		uploaded_spheres[uploaded_sphere_index].toursphere_uri = toursphere_url;
		uploaded_spheres[uploaded_sphere_index].isUploaded = is_uploaded;
	}
}

// get index of image vr in store uploaded image vr by id
function getUploadedSphereIndex(id) {
	for (i in uploaded_spheres) {
		if (uploaded_spheres[i].id == id) {
			return i;
		}
	}
	return null;
}

// update index of store position image vr
function updateSortSphereList(old_id, new_id) {
	for (i in sortSpheres) {
		if (sortSpheres[i] == old_id) {
			sortSpheres[i] = new_id;
		}
	}
}

// update store uploaded image vr
function sortUploadSpheresList() {
	var replaced_uploaded_spheres = new Array();
	for (i in plots) {
		var plot = plots[i];
		var sphere = getUploadedSphere(plot.id);

		replaced_uploaded_spheres.push(sphere);
	}

	for (i in uploaded_spheres) {
		var sphere = uploaded_spheres[i];
		if (getPlot(sphere.id) == null) {
			replaced_uploaded_spheres.push(sphere);
		}
	}

	uploaded_spheres = replaced_uploaded_spheres;
}

// refresh element
function clearFiles(id) {
	$('#' + id).replaceWith($("#" + id)[0].outerHTML);
}

// action selected image vr in block image vr
function selectSphere(id) {
	$('.sphere-item img').css('border', 'none');
	$('.sphere-item img').removeClass('selected-sphere');
	$('.sphere-close').remove();

	if (selected_sphere_id != null) {
		getUploadedSphere(selected_sphere_id).telopcontent = $('#scene-telop').val();
		$('#scene-telop').val('');
	}

	arc_selected = false;

	$('#' + id + " img").addClass("selected-sphere");
	var div = document.createElement("div");
	var content = document.createTextNode("X");
	div.appendChild(content);
	div.setAttribute("class", "sphere-close");
	$("#" + id).append(div);

	$('#scene-telop').css('visibility', 'visible');

	selected_sphere_id = id;

	$('#scene-telop').val(getUploadedSphere(selected_sphere_id).telopcontent);

	var plot = getPlot(id);
	setAllPointNotActive(plots);
	setAllArcNotActive(storedArc);
	if(plot != null) {
		setPointActive(plot, plots);
		setArcActive(plot, storedArc);
	}
	reDraw();

	insertPlotNumber();
}

// show krpano when selected image vr
function insertViewer(id) {
	if (embed_sphere_id != id) {
		embed_sphere_id = id;
		hideKrpanoView();
		var xml_path = '/vtour/pano.xml';
		var hlookat = getUploadedSphere(id).hlookat;
		settings["view.hlookat"] = hlookat;
		var equi_path = getUploadedSphere(id).equirectangular_uri;
		settings["image.sphere.url"] = equi_path;
		var vars_string = $.param(settings);
		var embedpano_dom = document.getElementById("krpanoSWFObject");
		embedpano_dom.call("loadpano(" + xml_path + "," + unescape(vars_string) + ",IGNOREKEEP,NOBLEND)");
	}
	return false;
}

// show loading in krpano
function hideKrpanoView() {
	$(".js-loading-layer").css('visibility','visible');
}

// hidden loading in krpano
function showKrpanoView() {
	$(".js-loading-layer").css('visibility','hidden');
}

// remove view of krpano when click remove image vr in block image vr
function removeKrpanoView() {
	var embedpano_dom = document.getElementById("krpanoSWFObject");
	embedpano_dom.call("loadpano(null);");

	$(".js-loading-layer").css('visibility','hidden');
}

// set hlookat of image in krpano. function called in xml config krpano
function setHlookatBefore() {
	var embedpano_dom = document.getElementById("krpanoSWFObject");
	hlookat_before = Number(embedpano_dom.get("view.hlookat"));

	if (isNaN(hlookat_before)) {
		hlookat_before = 0;
	}
}

// add a hotspot of image vr in krpano
function addHotSpotTo360View() {
	var embed_360view = document.getElementById("krpanoSWFObject");

	if(selected_sphere_id) {
		var links = $.grep(linked_plots, function(element, index) {
			return (element.start == selected_sphere_id || element.end == selected_sphere_id);
		});

		for (j in links) {
			var link = links[j];

			var next_sphere_id;
			if (link.start == selected_sphere_id) {
				next_sphere_id = link.end;
			} else {
				next_sphere_id = link.start;
			}

			var plot = getPlot(selected_sphere_id);
			var next_sphere_plot = getPlot(next_sphere_id);
			var plotnumber = parseInt(getPlotIndex(selected_sphere_id)) + 1;

			var link_angle = Math.atan2(next_sphere_plot.y - plot.y, next_sphere_plot.x - plot.x) * 180 / Math.PI;
			if (link_angle < 0) {
				link_angle = link_angle + 360;
			}

			var hotspotposition = calcHotSpotPosition(selected_sphere_id, next_sphere_id);
			var ath = hotspotposition.ath;
			var atv = hotspotposition.atv;

			var next_plot_number = parseInt(getPlotIndex(next_sphere_id)) + 1;

			if (link.start == selected_sphere_id && link.end == next_sphere_id) {
				if (typeof link.hotspot_forward_ath != "undefined") { ath = link.hotspot_forward_ath; }
				if (typeof link.hotspot_forward_atv != "undefined") { atv = link.hotspot_forward_atv; }
			}
			if (link.start == next_sphere_id && link.end == selected_sphere_id) {
				if (typeof link.hotspot_reverse_ath != "undefined") { ath = link.hotspot_reverse_ath; }
				if (typeof link.hotspot_reverse_atv != "undefined") { atv = link.hotspot_reverse_atv; }
			}

			var hotspot_name = "spot" + next_plot_number;
			if (typeof(embed_360view.call) == "function") {
				embed_360view.call("addhotspot(" + hotspot_name + ");");
				embed_360view.call("hotspot[" + hotspot_name + "].loadstyle(hotspot_notselected)");
				embed_360view.set("hotspot[" + hotspot_name + "].ath", ath);
				embed_360view.set("hotspot[" + hotspot_name + "].atv", atv);
				embed_360view.set("hotspot[" + hotspot_name + "].nextplotnumber", next_plot_number);
				embed_360view.set("plotnumber", plotnumber);
			}
		}
	}
}

// sync arc of point and of krpano
function sync_360viewToArc() {
	var embedpano_dom = document.getElementById("krpanoSWFObject");
	var hlookat = Number(embedpano_dom.get("view.hlookat"));
	if (isNaN(hlookat)) {
		hlookat = 0;
	}

	var sphereSelected = getUploadedSphere(selected_sphere_id);
	if(sphereSelected != null) {
		sphereSelected.hlookat = hlookat;
	}

	var hlookat_moving = hlookat - hlookat_before;

	if (!arc_selected) {
		var plotSelected = getPlot(selected_sphere_id);
		if(plotSelected != null) {
			plotSelected.startAngle += hlookat_moving * Math.PI / 180;
			updateArcAngle(plotSelected);
		}
	}

	reDraw();

	hlookat_before = hlookat;
}

// calculation position of hotspot
function calcHotSpotPosition(scene_id, linked_scene_id){
	var link_angle = Math.atan2(getPlot(linked_scene_id).y - getPlot(scene_id).y,
						getPlot(linked_scene_id).x - getPlot(scene_id).x) * 180 / Math.PI;
	if (link_angle < 0) {
		link_angle = link_angle + 360;
	}
	var ath = link_angle - ((getPlot(scene_id).startAngle * 180 / Math.PI + arc_angle / 2) - (getUploadedSphere(scene_id).hlookat % 360));
	var atv = 15;
	var hlookat = link_angle - ((getPlot(linked_scene_id).startAngle * 180 / Math.PI + arc_angle / 2)
					- (getUploadedSphere(linked_scene_id).hlookat % 360));

	var hotspot = { hlookat: hlookat, ath: ath, atv: atv };
	return hotspot;
}

// move hotspot in krpano, update linked store
function changeHotSpot(nextplotnumber){

	var embedpano = document.getElementById("krpanoSWFObject");
	var at_h = embedpano.get("mouseath").toFixed(2);
	var at_v = embedpano.get("mouseatv").toFixed(2);

	var next_sphere_id;
	next_sphere_id = plots[parseInt(nextplotnumber) -1].id;

	for (j in linked_plots) {
		if(linked_plots[j].start == selected_sphere_id && linked_plots[j].end == next_sphere_id){
			linked_plots[j].hotspot_forward_ath = at_h;
			linked_plots[j].hotspot_forward_atv = at_v;
		}

		if(linked_plots[j].start == next_sphere_id && linked_plots[j].end == selected_sphere_id){
			linked_plots[j].hotspot_reverse_ath = at_h;
			linked_plots[j].hotspot_reverse_atv = at_v;
		}
	}
}

// remove hotspot in krpano
function removeHotSpotTo360View(mouse_overed_link){
	var embed_360view = document.getElementById("krpanoSWFObject");

	var next_plot_number = parseInt(getPlotIndex(mouse_overed_link.start)) + 1;
	var hotspot_name = "spot" + next_plot_number;
	embed_360view.call("removehotspot(" + hotspot_name + ");");
	next_plot_number = parseInt(getPlotIndex(mouse_overed_link.end)) + 1;
	hotspot_name = "spot" + next_plot_number;
	embed_360view.call("removehotspot(" + hotspot_name + ");");
}

// remove a image in store uploaded image vr
function removeUploadedSphere() {
	id = selected_sphere_id;
	removeUploadedSphereById(id);

	$("#" + id).remove();

	$('#scene-telop').css('visibility', 'hidden');

	if ($('.js-scroll-area').children().length > 0) {
		insertPlotNumber();
	}
}

// remove a point in stored point and update index position
function removePlotPoint() {

	id = selected_sphere_id;

	removePlot(id);

	insertPlotNumber();
}

// remove a point in stored point
function removePlot(id) {
	for (i in plots) {
		if (plots[i].id == id) {
			var listLineRemove = checkLineRelateToPoint(plots[i], linked_plots);
			for (j in listLineRemove) {
				removeLineFormList(listLineRemove[j], linked_plots);
			}
			removeArcFormList(plots[i], storedArc);
			plots.splice(i, 1);
		}
	}
}

// check title of tour valid and get message if have error
function checkIllegalSphereTitle() {
	var scene_titles = document.getElementsByClassName("scene_title");
	for (i in scene_titles) {
		if (isIllegalText(scene_titles[i].value)) {
			return "IllegalSphereTitle";
		}
	}
}

// check title of tour valid
function isIllegalText(text) {
	regexp = /<|>|\[|\]/g;
	if (text == null) {
		return false;
	} else if (text.match(regexp) || text == "") {
		return true;
	} else {
		return false;
	}
}

// get point in stored point by id
function getPlot(id) {
	for (i in plots) {
		if (plots[i].id == id) {
			return plots[i];
		}
	}
	return null;
}

// get index of point in stored point by id
function getPlotIndex(id) {
	for (i in plots) {
		if (plots[i].id == id) {
			return i;
		}
	}
	return null;
}

// create a object element point
function createPlotInfo(id, x, y) {
	var plot_radius = parseInt('15');

	var plot = {
		id: id,
		x: x,
		y: y,
		text: '',
		active: false,
		startAngle : (arc_direction - arc_angle / 2) * Math.PI / 180,
		isPointInPlot : function(x, y) {
			if (x >= this.x - plot_radius && x <= this.x + plot_radius && y >= this.y - plot_radius && y <= this.y + plot_radius) {
				return true;
			} else {
				return false;
			}
		},
	};
	return plot;
}

// update text index image vr position
function updateMarkerPlot() {
	for (i in plots) {
		var text = $("#" + plots[i].id).children('.plot_number').children('p').text();
		plots[i].text = text;
	}
}

///////////////////////////////////////////////////////////////
// canvas point in minimap and krpano
///////////////////////////////////////////////////////////////
//
// get object krpano
function krpano() {
	return document.getElementById("krpanoSWFObject");
}

// active move mode canvas
$('.js-move-mode').click(function() {
	moveMode = true;
	linkMode = false;
	removeMode = false;
	$('canvas').css('cursor', 'default');
	$('.btn-create-tour').removeClass('btn-create-tour-active');
	$(this).addClass('btn-create-tour-active');

});
// active link mode canvas
$('.js-link-mode').click(function() {
	linkMode = true;
	moveMode = false;
	removeMode = false;
	$('canvas').css('cursor', 'default');
	$('.btn-create-tour').removeClass('btn-create-tour-active');
	$(this).addClass('btn-create-tour-active');
});
// active remove mode canvas
$('.js-remove-mode').click(function() {
	removeMode = true;
	linkMode = false;
	moveMode = false;
	$('canvas').css('cursor', 'crosshair');
	$('.btn-create-tour').removeClass('btn-create-tour-active');
	$(this).addClass('btn-create-tour-active');
});

$canvas.on({
	// action move mouse of canvas
	mousemove: function(e) {
		var mouseX = parseInt(e.pageX - offsetX);
		var mouseY = parseInt(e.pageY - offsetY);
		if (linkMode) {
			if (isDown) {
				if (mouseX < 5 || mouseX > widthCanvas - 5 || mouseY < 5 || mouseY > heightCanvas - 5) {
					reDraw();
					isDown = false;
				}
				else {
					reDraw();
					context.beginPath();
					context.lineWidth = 4;
					context.strokeStyle = "#494949";
					context.moveTo(startX, startY);
					context.lineTo(mouseX, mouseY);
					context.stroke();
				}
			}
		} else if (moveMode) {
			if (inCanvas) {
				flagNotMove = false;
				if (isDown) {
					if (mouseX < 10 || mouseX > widthCanvas - 10 || mouseY < 10 || mouseY > heightCanvas - 10) {
						plots.splice(parseInt(startMoveText) - 1, 0, { id: startMoveId, x: startMoveX, y: startMoveY, text: startMoveText, active: true, startAngle: startMoveAngle });
						for (var i = 0; i < lineRelate.length; i++) {
							linked_plots.push(lineRelate[i]);
						}
						reDraw();
						isDown = false;
						error = true;
					} else {
						reDraw();
						error = false;
						removePointFromList({ x: startMoveX, y: startMoveY }, plots);
						for (var i = 0; i < lineRelate.length; i++) {
							removeLineFormList(lineRelate[i], linked_plots);
						}
						for (var i = 0; i < pointRelate.length; i++) {
							drawLine({ x: pointRelate[i].x, y: pointRelate[i].y }, { x: mouseX, y: mouseY });
						}
						setAllPointNotActive(plots);
						setAllArcNotActive(storedArc);
						drawPoint({ x: mouseX, y: mouseY }, startMoveText, '#1E88E5');
					}
				}
				else if (arc_selected) {
					reDraw();
					var activePoint = getActivePoint(plots);
					removeArcFormList(activePoint, storedArc);
					var rad = Math.atan2(activePoint.y - mouseY, activePoint.x - mouseX);
					var rad_moving = rad - rad_before;
					startMoveAngle += rad_moving;
					rad_before = rad;
					drawArc(activePoint, startMoveAngle);
				}
			}
		}
		else if (removeMode) {
			var line_remove = checkPointInLine({ x: mouseX, y: mouseY });
			if (line_remove.x1 !== -1 && line_remove.y1 !== -1) {
				changeLineColor(line_remove, '#d50000', linked_plots);
			} else {
				changAllLineColor(linked_plots);
			}
			setAllArcNotActive(storedArc);
			reDraw();
		}
	},

	// action mouse down of canvas
	mousedown: function(e) {
		//e.preventDefault();
		var mouseX = parseInt(e.pageX - offsetX);
		var mouseY = parseInt(e.pageY - offsetY);
		var pointCheck = checkPointExistInList({ x: mouseX, y: mouseY }, plots);
		arcCheck = isArc(mouseX, mouseY);
		if (removeMode) {
			lineRemove = checkPointInLine({ x: mouseX, y: mouseY });
		} else {
			if (pointCheck.x !== -1 && pointCheck.y !== -1) {
				setAllArcNotActive(storedArc);
				error = false;
				isDown = true;
				if (linkMode) {
					startId = pointCheck.id;
					startX = pointCheck.x;
					startY = pointCheck.y;
				} else if (moveMode) {
					flagNotMove = true;
					inCanvas = true;
					startMoveX = pointCheck.x;
					startMoveY = pointCheck.y;
					startMoveText = pointCheck.text;
					startMoveId = pointCheck.id;
					startMoveAngle = pointCheck.startAngle;
					lineRelate = checkLineRelateToPoint({ x: startMoveX, y: startMoveY }, linked_plots);
					pointRelate = checkPointRelateToPoint({ x: startMoveX, y: startMoveY, id: startMoveId }, linked_plots);
				}
			}
			else if (arcCheck) {
				arc_selected = true;
				inCanvas = true;
				var plot = getActivePoint(plots);
				startMoveArcX = plot.x;
				startMoveArcY = plot.y;
				startMoveAngle = plot.startAngle;
				rad_before = Math.atan2(plot.y - mouseY, plot.x - mouseX);
			}
			else {
				error = true;
			}
		}
	},

	// action mouse up of canvas
	mouseup: function(e) {
		var mouseX = parseInt(e.pageX - offsetX);
		var mouseY = parseInt(e.pageY - offsetY);
		arcCheck = isArc(mouseX, mouseY);
		if (linkMode) {
			isDown = false;
			var pointCheck = checkPointExistInList({ x: mouseX, y: mouseY }, plots);
			if (pointCheck.x != -1 && pointCheck.y != -1 && startX !== 0 && startY !== 0) {
				var current_line = { start: startId, x1: startX, y1: startY, x2: pointCheck.x, y2: pointCheck.y, end: pointCheck.id, color: '#494949' };
				var flg = checkLinesExist(current_line);
				var flgDuplicate = checkDuplicateStartAndEndLine(current_line);
				if (!flg && !flgDuplicate) {
					linked_plots.push(current_line);
					addHotSpotTo360View();
				}
			}
		} else if (moveMode) {
			isDown = false;
			if (!error && !flagNotMove && !arc_selected && isPointInCanvas(mouseX, mouseY) && startMoveX !== 0 && startMoveY !== 0) {
				plots.splice(parseInt(startMoveText) - 1, 0, { id: startMoveId, x: mouseX, y: mouseY, text: startMoveText, active: true, startAngle: startMoveAngle });
				updateStoredArc(startMoveX, startMoveY, mouseX, mouseY);
				for (var i = 0; i < pointRelate.length; i++) {
					var resultLine = {};
					for (var j = 0; j < lineRelate.length; j++) {
						if (lineRelate[j].start == pointRelate[i].id || lineRelate[j].end == pointRelate[i].id) {
							resultLine = { x1: mouseX, y1: mouseY, x2: pointRelate[i].x, y2: pointRelate[i].y, color: '#494949', start: lineRelate[j].start, end: lineRelate[j].end };
							linked_plots.push(resultLine);
						}
					}
				}
				flagNotMove = true;
				inCanvas = false;
				startMoveX = 0;
				startMoveY = 0;

				addHotSpotTo360View();
				selectSphere(startMoveId);
				insertViewer(startMoveId);
			}
			else if (arc_selected) {
				arc_selected = false;
				storedArc.push({x: startMoveArcX,  y: startMoveArcY, startAngle: startMoveAngle, active: true});
				setPointStartAngle(startMoveArcX, startMoveArcY, startMoveAngle);
			}
			else if (flagNotMove) {
				var pointCheck = checkPointExistInList({ x: mouseX, y: mouseY }, plots);
				if (pointCheck.x !== -1 && pointCheck.y !== -1) {
					setAllPointNotActive(plots);
					setPointActive(pointCheck, plots);
					setAllArcNotActive(storedArc);
					setArcActive(pointCheck, storedArc);
					selectSphere(pointCheck.id);
					insertViewer(pointCheck.id);
				}
				startMoveX = 0;
				startMoveY = 0;
			}
		}
		else if (removeMode) {
			removeLineFormList(lineRemove, linked_plots);
			removeHotSpotTo360View(lineRemove);
		}
		reDraw();
	}
});

// redDraw points in stored point
function reDrawStoredPoint() {
	if (plots.length > 0) {
		for (var i = 0; i < plots.length; i++) {
			context.beginPath();
			context.lineWidth = 2;
			context.arc(plots[i].x, plots[i].y, R_POINT, 0, 2 * Math.PI, true);
			if (plots[i].active === true) {
				context.fillStyle = "#1E88E5";
			}
			else {
				context.fillStyle = "#494949";
			}
			context.fill();
			context.font = "14px Times New Roman";
			context.strokeStyle = "#fff";
			context.strokeText(plots[i].text, plots[i].x - 3, plots[i].y + 3);
		}
	}
}

// reDraw lines in stored lines
function reDrawStoredLines() {
	if (linked_plots.length > 0) {
		for (var i = 0; i < linked_plots.length; i++) {
			context.beginPath();
			context.lineWidth = 4;
			context.strokeStyle = linked_plots[i].color;
			context.moveTo(linked_plots[i].x1, linked_plots[i].y1);
			context.lineTo(linked_plots[i].x2, linked_plots[i].y2);
			context.stroke();
		}
	}
}

// reDraw canvas, stored points, stored lines, stored arc
function reDraw() {
	context.clearRect(0, 0, canvas.width, canvas.height);
	reDrawStoredLines();
	reDrawStoredPoint();
	reDrawStoredArc();
}

// check duplicate start and end of point
function checkDuplicateStartAndEndLine(line) {
	if (line.x1 == line.x2 && line.y1 == line.y2) {
		return true;
	}
	return false;
}

// check duplicate point
function checkSameLine(line1, line2) {
	if ((line1.x1 === line2.x1 && line1.y1 === line2.y1 &&
			line1.x2 === line2.x2 && line1.y2 === line2.y2) ||
		(line1.x1 === line2.x2 && line1.y1 === line2.y2 &&
			line1.x2 === line2.x1 && line1.y2 === line2.y1)) {
		return true;
	}
	return false;
}

// check line exist in stored line
function checkLinesExist(lineResource) {
	for (var i = 0; i < linked_plots.length; i++) {
		if (lineResource.x1 == linked_plots[i].x1 &&
			lineResource.x2 == linked_plots[i].x2 &&
			lineResource.y1 == linked_plots[i].y1 &&
			lineResource.y2 == linked_plots[i].y2) {
			return true;
		} else if (lineResource.x1 == linked_plots[i].x2 &&
			lineResource.x2 == linked_plots[i].x1 &&
			lineResource.y1 == linked_plots[i].y2 &&
			lineResource.y2 == linked_plots[i].y1) {
			return true;
		}
	}
	return false;
}

// get point in stored point
function checkPointExistInList(pointCheck, arrayPoint) {
	for (var i = 0; i < arrayPoint.length; i++) {
		var dist = Math.abs(Math.sqrt(Math.pow(pointCheck.x - arrayPoint[i].x, 2) +
			Math.pow(pointCheck.y - arrayPoint[i].y, 2)));
		if (dist < R_POINT) {
			return {id: arrayPoint[i].id, x: arrayPoint[i].x, y: arrayPoint[i].y, text: arrayPoint[i].text, startAngle: arrayPoint[i].startAngle };
		}
	}
	return { x: -1, y: -1 };
}

// change line color by line
function changeLineColor(line, color, arrayLine) {
	for (var i = 0; i < arrayLine.length; i++) {
		if (checkSameLine(line, arrayLine[i])) {
			arrayLine[i].color = color;
		}
	}
	return true;
}

// chnage all line color
function changAllLineColor(arrayLine) {
	for (var i = 0; i < arrayLine.length; i++) {
		arrayLine[i].color = '#494949';
	}
}

// update arc in stored arc
function updateStoredArc(old_x, old_y, new_x, new_y) {
	for (var i = 0; i < storedArc.length; i++) {
		if (storedArc[i].x === old_x && storedArc[i].y === old_y) {
			storedArc[i].x = new_x;
			storedArc[i].y = new_y;
			return true;
		}
	}
	return false;
}

// update arc of point
function updateArcAngle(point) {
	for (var i = 0 ; i < storedArc.length; i++) {
		if (point.x === storedArc[i].x && point.y === storedArc[i].y) {
			storedArc[i].startAngle = point.startAngle;
			return true;
		}
	}
	return false;
}

// remove point in stored point
function removePointFromList(removePoint, arrayPoint) {
	var pos = -1;
	for (var i = 0; i < arrayPoint.length; i++) {
		if (removePoint.x === arrayPoint[i].x && removePoint.y === arrayPoint[i].y) {
			pos = i;
		}
	}
	if (pos !== -1) {
		arrayPoint.splice(pos, 1);
	}
}

// remove line in stored line
function removeLineFormList(removeLine, arrayLine) {
	var pos = -1;
	for (var i = 0; i < arrayLine.length; i++) {
		if (checkSameLine(removeLine, arrayLine[i])) {
			pos = i;
			lineRemove.start = arrayLine[i].start;
			lineRemove.end = arrayLine[i].end;
		}
	}
	if (pos !== -1) {
		arrayLine.splice(pos, 1);
	}
}

// get lines relate by point
function checkLineRelateToPoint(point, arrayLine) {
	var lineList = [];
	for (var i = 0; i < arrayLine.length; i++) {
		if ((point.x === arrayLine[i].x1 && point.y === arrayLine[i].y1) ||
			(point.x === arrayLine[i].x2 && point.y === arrayLine[i].y2)) {
			lineList.push(arrayLine[i]);
		}
	}
	return lineList;
}

// get point relate by point with lines of point
function checkPointRelateToPoint(point, arrayLine) {
	var pointList = [];
	var id = "";
	for (var i = 0; i < arrayLine.length; i++) {
		if (point.x === arrayLine[i].x1 && point.y === arrayLine[i].y1) {
			if (arrayLine[i].start == point.id) {
				id = arrayLine[i].end;
			} else {
				id = arrayLine[i].start;
			}
			pointList.push({ x: arrayLine[i].x2, y: arrayLine[i].y2, id: id });
		} else if (point.x === arrayLine[i].x2 && point.y === arrayLine[i].y2) {
			if (arrayLine[i].start == point.id) {
				id = arrayLine[i].end;
			} else {
				id = arrayLine[i].start;
			}
			pointList.push({ x: arrayLine[i].x1, y: arrayLine[i].y1, id: id });
		}
	}
	return pointList;
}

// get line of point
function checkPointInLine(point) {
	var line = {};
	for (var i = 0; i < linked_plots.length; i ++) {
		var pointStart = getPlot(linked_plots[i].start);
		var pointEnd = getPlot(linked_plots[i].end);
		var distance = getDistanceFromPointToLine(point, pointStart, pointEnd);
		if (distance < 2 && checkInsideLine(point.x, pointStart.x, pointEnd.x) && checkInsideLine(point.y, pointStart.y, pointEnd.y)) {
			line = { x1: pointStart.x, y1: pointStart.y, x2: pointEnd.x, y2: pointEnd.y };
			return line;
		}
	}
	return { x1: -1, y1: -1, x2: -1, y2: -1 };
}

// check point inside line
function checkInsideLine(point, pointA, pointB) {
	var result = false;
	if (pointA > pointB) {
		if(point < pointA && point > pointB) {
			result = true;
		}
	}
	else {
		if(point > pointA && point < pointB) {
			result = true;
		}
	}
	return result;
}

// get distance of point to line created 2 point
function getDistanceFromPointToLine(point, point1, point2) {
	var a = point2.y - point1.y;
	var b = point2.x - point1.x;
	var numerator = Math.abs(a * point.x - b * point.y + (point2.x * point1.y) - (point2.y * point1.x));
	var denominator = Math.sqrt(a * a + b * b);
	var dis = numerator / denominator;
	return dis;
}

// set point active in stored point
function setPointActive(plot, storedPoint) {
	for (var i = 0; i < storedPoint.length; i++) {
		if (storedPoint[i].x === plot.x && storedPoint[i].y === plot.y) {
			storedPoint[i].active = true;
			return true;
		}
	}
	return false;
}

// get point active in stored point
function getActivePoint(storedPoint) {
	for (var i = 0; i < storedPoint.length; i++)  {
		if (storedPoint[i].active === true){
			return storedPoint[i];
		}
	}
	return 0;
}

// set all point to not active
function setAllPointNotActive(storedPoint) {
	for (var i = 0; i < storedPoint.length; i++) {
		storedPoint[i].active = false;
	}
}

// set arc active in stored arc
function setArcActive(plot, storedArc) {
	for (var i = 0; i < storedArc.length; i++) {
		if (storedArc[i].x === plot.x && storedArc[i].y === plot.y) {
			storedArc[i].active = true;
			return true;
		}
	}
	return false;
}

// set all arc to not active
function setAllArcNotActive(storedArc) {
	for (var i = 0; i < storedArc.length; i++) {
		storedArc[i].active = false;
	}
}

// set arc for point
function setPointStartAngle(x,y,angle) {
	for (var i = 0; i < plots.length; i++) {
		if (x === plots[i].x && y === plots[i].y) {
			plots[i].startAngle = angle;
			return true;
		}
	}
	return false;
}

// remove arc from stored arc
function removeArcFormList(removeArc, arrayArc) {
	var pos = -1;
	for (var i = 0; i < arrayArc.length; i++) {
		if (removeArc.x === arrayArc[i].x && removeArc.y === arrayArc[i].y) {
			pos = i;
		}
	}
	if (pos !== -1) {
		arrayArc.splice(pos, 1);
	}
}

// check point have in canvas
function isPointInCanvas(mouseX, mouseY) {
	if (mouseX > 10 && mouseY > 10 && mouseX < widthCanvas - 10 && mouseY < heightCanvas - 10) {
		return true;
	}
	return false;
}

// redraw stored arc
function reDrawStoredArc() {
	var plot_radius = parseInt('15');
	var arc_radius = parseInt('45');
	var arc_angle = parseInt('100');
	if (storedArc.length > 0) {
		for (var i = 0; i < storedArc.length; i++) {
			if (storedArc[i].active === true) {
				context.beginPath();
				var endAngle = storedArc[i].startAngle + (arc_angle * Math.PI / 180)
				context.arc(storedArc[i].x, storedArc[i].y, arc_radius, storedArc[i].startAngle, endAngle,
				false);
				context.arc(storedArc[i].x, storedArc[i].y, plot_radius, endAngle, storedArc[i].startAngle,
				true);
				context.fillStyle = "#64B5F6";
				context.fill();
			}
		}
	}
}

// check arc in canvas
function isArc(x, y) {
	var plot_radius = parseInt('15');
	var arc_radius = parseInt('45');
	var arc_angle = parseInt('100');
	var plot = getActivePoint(plots);
	var endAngle = plot.startAngle + (arc_angle * Math.PI / 180);
	context.beginPath();
	context.arc(plot.x, plot.y, arc_radius, plot.startAngle, endAngle, false);
	context.arc(plot.x, plot.y, plot_radius, endAngle, plot.startAngle, true);
	if (context.isPointInPath(x, y)) {
		return true;
	} else {
		return false;
	}
}

// draw arc
function drawArc(plot, angle) {
	var plot_radius = parseInt('15');
	var arc_radius = parseInt('45');
	var arc_angle = parseInt('100');
	var endAngle = angle + (arc_angle * Math.PI / 180);
	context.beginPath();
	context.arc(plot.x, plot.y, arc_radius, angle, endAngle,
	false);
	context.arc(plot.x, plot.y, plot_radius, endAngle, angle,
	true);
	context.fillStyle = "#029fdc";
	context.fill();
}

// draw line
function drawLine(point1, point2) {
	context.beginPath();
	context.lineWidth = 4;
	context.strokeStyle = "#494949";
	context.moveTo(point1.x, point1.y);
	context.lineTo(point2.x, point2.y);
	context.stroke();
};

// draw point
function drawPoint(point, text, color) {
	context.beginPath();
	context.lineWidth = 1;
	context.arc(point.x, point.y, R_POINT, 0, 2 * Math.PI, true);
	context.fillStyle = color;
	context.fill();
	context.font = "14px Times New Roman";
	context.strokeStyle = "#fff";
	context.strokeText(text, point.x - 3, point.y + 3);
}

// check duplicate link
function isDuplicatedLinkedPlot(start_id, end_id) {

    var existing = $.grep(linked_plots, function(element, index) {
        return (element.start == start_id && element.end == end_id)
            || (element.start == end_id && element.end == start_id);
    });

    if (existing.length < 1) {
        return false;
    } else {
        return true;
    }
}

// create object link element
function createLinkInfo(start) {
    var link = {
        start : start,
        end : null
    };
    return link;
}

// get duplicate link
function getDuplicatedLinkedPlot(start_id, end_id) {

    var links = new Array;

    for (j in linked_plots) {
        if(linked_plots[j].start == start_id && linked_plots[j].end == end_id ||
            linked_plots[j].start == end_id && linked_plots[j].end == start_id){
            links.push(linked_plots[j]);
        }
    }

    return links[0];
}

///////////////////////////////////////////////////////////////
// functions upload minimap
///////////////////////////////////////////////////////////////
//
// upload image minimap
function uploadFloorMap(file) {
	deleteMessage();

	var file = file;

	if (floormap_layer != null) {
		$('.js-replace-floormap-dialog').dialog({
			autoOpen : false,
			closeOnEscape : false,
			modal : true,
			dialogClass: "common-dialog",
			resizable: false,
			draggable: false,
			open:function(event, ui) {
				$("#pano").css('height','0%');
				$(".common-dialog").css("z-index", "9999");
				$(".ui-dialog-titlebar-close").hide();
				$(".ui-dialog-titlebar").css("background", "url(/resource/img/exclamation.png) no-repeat top");
				$(".ui-dialog-titlebar").css("background-size", "40px 40px");
			},
			close: function(event, ui) {
				$("#pano").css('height','100%');
			},
			buttons : [
			{
				text: button_ok,
				click: function() {
					$(this).dialog('close');
					var ret = checkTourPlane(file);
					var message = get_message(ret, file.name);

					if (message != null) {
						deleteMessage();
						insertErrorMessage(message);
					} else {
						floormap_spinner.spin($('.js-round-floor-plan').get(0));
						$('.floormap-overlay').fadeIn();
						postingFloorMap(file);
					}

					clearFiles("file_floormap");
				},
				class: "btn-in-dialog"
			},
			{
				text: button_cancel,
				click: function() {
					$(this).dialog('close');
					clearFiles("file_floormap");
				},
				class: "btn-in-dialog"
			}]
		});
		body = JAICO0002;
		$(".js-replace-floormap-dialog").html(body);
		$(".js-replace-floormap-dialog").dialog("open");
		return false;
	}

	var ret = checkTourPlane(file);
	var message = get_message(ret, file.name);

	if (message != null) {
		deleteMessage();
		insertErrorMessage(message);
	} else {
		floormap_spinner.spin($('.js-round-floor-plan').get(0));
		$('.floormap-overlay').fadeIn();
		postingFloorMap(file);
	}
	clearFiles("file_floormap");
}

// check image minimap valid
function checkTourPlane(file) {
	if (IsImageFile(file) == false) {
		return "CanNotPost";
	}
	if (IsZeroByte(file) == false) {
		return "ZeroByte";
	}
}

// check file is image
function IsImageFile(file) {
	var fileName = file.name;
	var Extension = getExtension(fileName);

	if (Extension.toLowerCase() === "jpg" || Extension.toLowerCase() === "jpeg"
		|| Extension.toLowerCase() === "png" || Extension.toLowerCase() === "gif") {
		return true;
	} else {
		return false;
	}
}

// upload minimap and insert minimap in database
function postingFloorMap(file) {
	var formData = new FormData();
	formData.append('file', file);
	formData.append('type', 1);

	var floormap_source;

	$.ajax('/admincp/house/upload-plan-photo', {
		method : 'POST',
		contentType : false,
		processData : false,
		data : formData,
		dataType : 'json',
		timeout: 120000,
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			var error_message = null;
			if (textStatus == "timeout") {
				error_message = get_message("FailedToUploadFile", file.name);
			} else if (XMLHttpRequest.responseJSON) {
				var response_json = XMLHttpRequest.responseJSON;

				if (XMLHttpRequest.status == "401") {
					error_message = (response_json.error);
					//Start login if need
					//End login if need
					return;
				} else {
					error_message = (response_json.error_message);
				}
			} else{
				error_message = get_message("FailedToUploadFile", file.name);
			}
			deleteMessage();
			insertErrorMessage(error_message);
			floormap_spinner.stop();
			$('.floormap-overlay').fadeOut();
		},
		success: function(data) {
			floormap_source = (data.source);
			floormap_id = (data.id);
			floormap_layer = createFloormapLayer(floormap_source);
			$('.js-tour-map').val(data.id);

			insertFloorMap(floormap_source, floormap_id);
		}
	});
}

// create object element minimap
function createFloormapLayer(url) {
	var floormap = {
		name : "map",
		style : "ot_style_minimap_container",
		url : url,
		keep : true,
		align : "lefttop",
		scale : 1,
		handcursor : false,
		scalechildren : true,
		maskchildren : true
	};
	return floormap;
}

// insert minimap in block
function insertFloorMap(floormap_source, floormap_id, callback) {
	jsobj_rebuild_queue.push("true");
	var image = new Image();
	image.id = "floormap_img";

	image.onload = function() {

		var thumbnail_width = $(".js-round-floor-plan").width();
		var thumbnail_height = $(".js-round-floor-plan").height();

		image_width = image.width;
		image_height = image.height;
		plot_scale = Math.min(thumbnail_width / image_width, thumbnail_height / image_height);

		floormap_width = parseInt(image_width * plot_scale);
		floormap_height = parseInt(image_height * plot_scale);

		image.setAttribute("width", floormap_width);
		image.setAttribute("height", floormap_height);
		image.setAttribute("draggable", false);
		image.setAttribute("data-id", floormap_id);

		$(".js-drop-floormap").hide();

		$("#floormap_img").remove();
		$(".js-img-minimap").append(image);

		$(".js-delete-floormap").prop('disabled', false);
		$(".js-move-mode").removeClass('disabled');
		$(".js-link-mode").removeClass('disabled');

		$('.js-wrap-floor-plan').attr("width", floormap_width);
		$('.js-wrap-floor-plan').attr("height", floormap_height);
		$('.js-wrap-floor-plan').css({ "top": image.offsetTop });
		$('.js-wrap-floor-plan').css({ "left": 10 });
		$('.js-wrap-floor-plan').css({ "right": 10 });
		$('.js-wrap-floor-plan').css({ "bottom": image.offsetTop });

		$('.js-wrap-floor-plan').show();

		$canvas.attr("width", $canvasRound.width() + "px");
		$canvas.attr("height", $canvasRound.height() + "px");
		canvas = document.getElementById("floor-plan");
		context = canvas.getContext("2d");
		context.strokeStyle = "#15a1b1";
		offsetX = $canvas.offset().left;
		offsetY = $canvas.offset().top;

		removePlotPoint();

		plots = new Array();
		linked_plots = new Array();

		floormap_spinner.stop();

		insertPlotNumber();

		$('.floormap-overlay').fadeOut();
		jsobj_rebuild_queue.splice(0,1);
		if (callback != null) {
			callback();
		}
		widthCanvas = $("#floor-plan").width();
		heightCanvas = $("#floor-plan").height();
	};

	image.onerror = function() {
		jsobj_rebuild_queue.splice(0,1);
		deleteMessage();
		insertErrorMessage(error_message);
	};

	image.src = floormap_source;
	$('#floormapImage').val(floormap_id);
}

// dialog confirm delete minimap
function confirm_delete_floormap() {
	$('.js-delete-floormap-dialog').dialog({
		autoOpen : false,
		closeOnEscape : false,
		modal : true,
		dialogClass: "common-dialog",
		open: function(event, ui) {
			$("#pano").css('height','0%');
			$(".common-dialog").css("z-index", "99999");
			$(".ui-dialog-titlebar-close").hide();
			$(".ui-dialog-titlebar").css("background", "url(/resource/img/exclamation.png) no-repeat top");
			$(".ui-dialog-titlebar").css("background-size", "40px 40px");
		},
		close:function(event, ui) {
			$("#pano").css('height','100%');
		},
		buttons : [{
			text: button_ok,
			click: function() {
				$(this).dialog('close');

				var floormap_img_id = $("#floormap_img").attr('data-id');
				deleteFloorMap(floormap_img_id);
			},
			class: "btn-in-dialog"
		},
		{
			text: button_cancel,
			click: function() {
				$(this).dialog('close');
			},
			class: "btn-in-dialog"
		}]
	});
	body = JAICO0002;
	$(".js-delete-floormap-dialog").html(body);
	$(".js-delete-floormap-dialog").dialog("open");
	return false;
}

// delete minimap in block
function deleteFloorMap(floormap_img_id) {
	var formData = new FormData();
	formData.append('id', floormap_img_id);
	floormap_layer = null;
	$("#floormap_img").remove();

	$canvas = $("#floor-plan");
	$canvas.attr("width", "1px");
	$canvas.attr("height", "1px");
	$canvasRound = $(".js-wrap-floor-plan");
	canvas = document.getElementById("floor-plan");
	context = canvas.getContext("2d");

	$(".js-drop-floormap").show();
	$(".js-delete-floormap").prop('disabled', true);

	removePlotPoint();

	plots = new Array();
	linked_plots = new Array();
	storedArc = new Array();

	insertPlotNumber();
	// $.ajax('/admincp/house/delete-plan-photo', {
	// 	method : 'POST',
	// 	contentType : false,
	// 	processData : false,
	// 	data : formData,
	// 	dataType : 'json',
	// 	timeout: 120000,
	// 	error: function(XMLHttpRequest, textStatus, errorThrown) {
	// 		var error_message = null;
	// 		if (textStatus == "timeout") {
	// 			error_message = get_message("FailedToDeleteFile");
	// 		} else if (XMLHttpRequest.responseJSON) {
	// 			var response_json = XMLHttpRequest.responseJSON;

	// 			if (XMLHttpRequest.status == "401") {
	// 				error_message = (response_json.error);
	// 				//Start login if need
	// 				//End login if need
	// 				return;
	// 			} else {
	// 				error_message = (response_json.error_message);
	// 			}
	// 		} else{
	// 			error_message = get_message("FailedToDeleteFile");
	// 		}
	// 		deleteMessage();
	// 		insertErrorMessage(error_message);
	// 		floormap_spinner.stop();
	// 		$('.floormap-overlay').fadeOut();
	// 	},
	// 	success: function(data) {
	// 		if(data == true) {

	// 		}
	// 	}
	// });
}

///////////////////////////////////////////////////////////////
// functions save tour
///////////////////////////////////////////////////////////////
//
// Save or edit a tour
function uploadTour(editfrom, tour_id) {
	deleteMessage();
	var rets = checkTour(CHECK_KBN_UPLOAD_TOUR);
	//var tourTitle = $("#tour_title").val();
	if (rets.length > 0) {
		$.each(rets, function(i, value) {
			var message = get_message(value, "");
			insertErrorMessage(message);
		});
	} else {
		var tour_param_json = combineTourParam();
		$(".js-tour-param").val(tour_param_json);
		$("#tour_title_param").val($("#tour_title").val());
		$("#tour_custom_key_param").val($("#tour_custom_key").val());

		if (editfrom == 'tour') {
			$("#postTour").attr("action", "/admincp/house/save/" + tour_id);
		} else if (editfrom == 'new') {
			$("#postTour").attr("action", "/admincp/house/save");
		}

		$("#postTour").attr("target", "_self");
		$("#postTour").submit();
	}
	return false;
}

// check tour is valid
function checkTour(kind) {
	var messages = new Array();

	var title = $(".js-tour-title").val();
	if (title == null) {
		title = "";
	}
	var trimTitle = title.replace(/(^\s+)|(\s+$)/g, "");

	var tour_title_check_result = checkIllegalTourTitle();

	var tour_custom_key_check_result = checkIllegalTourCustomkey();

	var scene_title_check_result = checkIllegalSphereTitle();

	if (during_restore) {
		if (kind == CHECK_KBN_UPLOAD_TOUR) {
			messages.push("DuringRestoreWhenRelease");
		} else if (kind == CHECK_KBN_PREVIEW) {
			messages.push("DuringRestoreWhenPreview");
		}
	} else if (!$("#floormap_img")[0]) {
		messages.push("NoFloorMap");
	} else if (!$(".input-location").val()) {
		messages.push("NoLocation");
	} else if (uploaded_spheres.length < 1 && kind == CHECK_KBN_UPLOAD_TOUR) {
		messages.push("NoSpheres");
	} else if (tour_title_check_result != null || scene_title_check_result != null || tour_custom_key_check_result != null) {
		if (tour_title_check_result != null) {
			messages.push(tour_title_check_result);
		}
		if (tour_custom_key_check_result != null) {
			messages.push(tour_custom_key_check_result);
		}
		if (scene_title_check_result != null) {
			messages.push(scene_title_check_result);
		}
	} else if (floormap_layer != null && kind == CHECK_KBN_UPLOAD_TOUR) {
		if (plots.length < 1) {
			messages.push("NoPlot");
		}
	}
	if (duringAjax || jsobj_rebuild_queue.length > 0) {
		if (kind == CHECK_KBN_UPLOAD_TOUR) {
			messages.push("DuringAjaxWhenRelease");
		} else if (kind == CHECK_KBN_PREVIEW) {
				messages.push("DuringAjaxWhenPreview");
		}
	}
	return messages;
}

// check tour title is valid
function checkIllegalTourTitle() {
	if (isIllegalText($(".js-tour-title").val())) {
		return "IllegalTourTitle";
	}
}

// check tour key is valid
function checkIllegalTourCustomkey() {
	var text = $(".js-tour-key").val();
	var result = null;
	regexp = /^[a-zA-Z0-9]+$/i;
	if (text == '') {
		return result;
	} else if (text.match(regexp)) {
		var formData = new FormData();
		formData.append('key', text);

		$.ajax('/admincp/house/check-tour-key', {
			method : 'POST',
			contentType : false,
			processData : false,
			data : formData,
			dataType : 'json',
			timeout: 120000,
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				if (textStatus == "timeout") {
					result = get_message("FailedToCheckTourKey");
				} else if (XMLHttpRequest.responseJSON) {
					var response_json = XMLHttpRequest.responseJSON;

					if (XMLHttpRequest.status == "401") {
						result = (response_json.error);
						//Start login if need
						//End login if need
						return;
					} else {
						result = (response_json.error_message);
					}
				} else{
					result = get_message("FailedToCheckTourKey");
				}
				deleteMessage();
				insertErrorMessage(result);
			},
			success: function(data) {
				if(data == true) {
					result = "ExistTourKey";
				}
			}
		});
		return result;
	} else {
		result = "IllegalTourCustomkey";
		return result;
	}
}

// create json config of tour
function combineTourParam() {
	var tour_request_body = createTourParam();

	tour_request_body.krpano.title = $(".js-tour-title").val();

	if (floormap_layer != null) {
		tour_request_body.krpano.layer.push($.extend(true, {}, floormap_layer));
	}

	var plot_layers = new Array();
	var scenes = new Array();
	var scenedrafts = new Array();
	var spheres = new Array();
	for (i in uploaded_spheres) {
		var uploaded_sphere = uploaded_spheres[i];
		var plot = getPlot(uploaded_sphere.id);

		var sphere_number = ('0' + i).slice(-2);

		var teloplen = countLength(uploaded_sphere.telopcontent);
		teloplen = teloplen * 13;

		var telop = uploaded_sphere.telopcontent;
		telop = telop.replace( /'/g , "0x0027" );
		telop = telop.replace( /"/g , "0x0022" );
		telop = telop.replace( /,/g , "0x002C" );
		telop = telop.replace( /</g , "0x003C" );
		telop = telop.replace( />/g , "0x003E" );
		telop = telop.replace( /\[/g , "0x005B" );
		telop = telop.replace( /\]/g , "0x005D" );
		telop = telop.replace( /&/g , "0x0026" );

		var view = createView(uploaded_sphere.hlookat);

		var hotspots = new Array();

		var plugins_path = '/vtour/plugins/';

		var first_arc_angle;

		if (plot != null) {
			var plot_layer = createPlotLayer(uploaded_sphere.id, sphere_number, plot.x, plot.y, plot_scale);
			var plot_index = getPlotIndex(plot.id);
			plot_layers[plot_index] = plot_layer;

			var arc_angle = parseInt('100');
			first_arc_angle = (plot.startAngle * 180 / Math.PI + arc_angle / 2) + 90 - (uploaded_sphere.hlookat % 360);

			var links = $.grep(linked_plots, function(element, index) {
				return (element.start == uploaded_sphere.id || element.end == uploaded_sphere.id);
			});

			for (j in links) {
				var link = links[j];
				var start_sphere_id;
				var next_sphere_id;
				var changed_ath = null;
				var changed_atv = null;

				if (link.start == uploaded_sphere.id) {
					start_sphere_id = link.start;
					next_sphere_id = link.end;
					changed_ath = link.hotspot_forward_ath;
					changed_atv = link.hotspot_forward_atv;
				} else {
					start_sphere_id = link.end;
					next_sphere_id = link.start;
					changed_ath = link.hotspot_reverse_ath;
					changed_atv = link.hotspot_reverse_atv;
				}

				var hotspotposition = calcHotSpotPosition(start_sphere_id, next_sphere_id);
				var ath = hotspotposition.ath;
				var atv = hotspotposition.atv;
				var hlookat = hotspotposition.hlookat;

				var next_plot_number = getPlotIndex(next_sphere_id);
				next_plot_number = ('0' + next_plot_number).slice(-2);

				if (changed_ath == null) {
					hotspots.push(createLinkHotSpot(j, sphere_number, uploaded_sphere.id, next_plot_number, next_sphere_id, ath, atv, hlookat));
				} else {
					hotspots.push(createLinkHotSpot(j, sphere_number, uploaded_sphere.id, next_plot_number, next_sphere_id, changed_ath, changed_atv, hlookat));
				}
			}
		}

		var temp_scene = createScene(uploaded_sphere.id, sphere_number, uploaded_sphere.equiThumbnail_uri,
									uploaded_sphere.equirectangular_uri,
									uploaded_sphere.title, uploaded_sphere.toursphere_uri,
									first_arc_angle, telop, teloplen);

		temp_scene.hotspot = hotspots;
		temp_scene.view = view;

		if (floormap_layer == null) {
			scenes.push(temp_scene);
		} else if (plot != null) {
			var plot_index = getPlotIndex(plot.id);
			scenes[plot_index] = temp_scene;
		} else {
			scenedrafts.push(temp_scene);
		}

		var sphere = createSphere(uploaded_sphere.id, uploaded_sphere.title);

		if (floormap_layer == null) {
			sphere.used = "true";
		} else {
			var plot = getPlot(uploaded_sphere.id);
			if (plot != null) {
				sphere.used = "true";
			}
		}
		spheres.push(sphere);
	}

	if (tour_request_body.krpano.layer != null) {
		if (plot_layers.length > 0) {
			tour_request_body.krpano.layer[0].layer = plot_layers;
		}
	}
	if (scenes.length > 0) {
		tour_request_body.krpano.scene = scenes;
	}

	if (scenedrafts.length > 0) {
		tour_request_body.krpano.scenedraft = scenedrafts;
	}

	if (spheres.length > 0) {
		tour_request_body.spheres = spheres;
	}
	console.log(tour_request_body);
	tour_custom_key = $(".js-tour-key").val();
	var metadata = createTourMetadata(tour_custom_key, "");
	tour_request_body.metadata = metadata;

	tour_published = $(".js-tour-published-param").val();
	if (tour_published != "" && tour_published != null) {
		tour_request_body.published = tour_published;
	}

	return JSON.stringify(tour_request_body);
}

// create krpano element param json
function createTourParam() {
	var tourparam = {
		krpano: {
			version: "1.19",
			title: "Virtual Tour",
			onstart: "startup();",
			include: [
				{
					url: '/vtour/plugins.xml'
				}],
			autorotate: [
				{
					enabled: true,
					speed: "5.0"
				}
			],
			layer: []
		}
	};

	return tourparam;
}

// count length string
function countLength(str) {
	var r = 0;
	for (var i = 0; i < str.length; i++) {
		var c = str.charCodeAt(i);
		if ((c >= 0x0 && c < 0x81) || (c == 0xf8f0) || (c >= 0xff61 && c < 0xffa0) || (c >= 0xf8f1 && c < 0xf8f4)) {
			r += 1;
		} else {
			r += 2;
		}
	}
	return r;
}

// create view element param json
function createView(hlookat) {
	str_hlookat = String(floorDecimal(hlookat, 5));

	var view = {
		hlookat: str_hlookat,
		vlookat: "0.0",
		fov: "60",
		fovmin: "30",
		fovmax: "80",
		fisheye: "1.0"
	};

	return view;
}

// convert number to decimal
function floorDecimal(value, digit) {
	num = Number(value);
	if (isInteger(num)) {
		num = num.toFixed(1);
	} else {
		pow_result = Math.pow(10, digit);
		num = Math.floor(value * pow_result) / pow_result;
	}
	return num;
}

// convert number to interger
function isInteger(value) {
	value = parseFloat(value);
	return Math.round(value) === value;
}

// create point element param json
function createPlotLayer(sphere_id, plot_number, x, y, scale) {
	var plot = {
		style : "ot_style_minimap_point",
		name : "spot" + plot_number + "_" + sphere_id,
		x : x / scale,
		y : y / scale,
		onclick : "loadscene(scene" + plot_number + "_" + sphere_id + ",null,MERGE,BLEND(1));",
		linkedscene : "scene" + plot_number + "_" + sphere_id
	};
	return plot;
}

// create hotspot element param json
function createLinkHotSpot(link_number, plot_number, sphere_id, next_plot_number, next_sphere_id, ath, atv, hlookat) {
	var link = {
		name : "scene" + plot_number + "_" + sphere_id + "_" + link_number,
		style : "skin_hotspotstyle",
		ath : ath,
		atv : atv,
		linkedscene : "scene" + next_plot_number + "_" + next_sphere_id,
		loadvars : "view.hlookat=" + hlookat
	};

	return link;
}

// create scene element param json
function createScene(sphere_id, plot_number, equiThumbnail_url, equirectangular_url, title, toursphere_url, angle, telop, teloplen) {
	var scene = {
		name : "scene" + plot_number + "_" + sphere_id,
		title : title,
		thumburl : equiThumbnail_url,
		toursphereurl : toursphere_url,
		onstart : "settelop(" + telop + ",-" + teloplen + ");activatespot(spot" + plot_number + "_" + sphere_id + "," + angle + ");setbottomurl();",
		preview : {
			url : equiThumbnail_url
		},
		image : {
			sphere : {
				url : equirectangular_url
			}
		}
	};
	return scene;
};

// create image element param json
function createSphere(id, title) {
	var sphere = {
		id : id,
		title : title,
		used : "false"
	};
	return sphere;
}

// create meta data element param json
function createTourMetadata(custom_key, note) {
	var metadata = {
		custom_key : custom_key,
		note : note
	};
	return metadata;
}

// load restore all for edit tour
function restoreAll() {
	var image = new Image();
	image.id = "floormap_img";

	var floorMapUrl = $('.ot-floormap-url').val();
	var tmp = floorMapUrl.slice(2);
	floorMapUrl = '/uploads/plans/' + tmp.slice(0, tmp.length - 2);
	var floorMapId =  $('.ot-floormap-id').val();
	floormap_layer = createFloormapLayer(floorMapUrl);
	$('.js-tour-map').val(floorMapId);

	image.onload = function() {
		var thumbnail_width = $(".js-round-floor-plan").width();
		var thumbnail_height = $(".js-round-floor-plan").height();
		image_width = image.width;
		image_height = image.height;
		plot_scale = Math.min(thumbnail_width / image_width, thumbnail_height / image_height);
		floormap_width = parseInt(image_width * plot_scale);
		floormap_height = parseInt(image_height * plot_scale);

		image.setAttribute("width", floormap_width);
		image.setAttribute("height", floormap_height);
		image.setAttribute("draggable", false);
		image.setAttribute("data-id", floorMapId);

		$(".js-drop-floormap").hide();

		$("#floormap_img").remove();
		$(".js-img-minimap").append(image);

		$(".js-delete-floormap").prop("disabled", false);
		$(".js-move-mode").removeClass('disabled');
		$(".js-link-mode").removeClass('disabled');

		$('.js-wrap-floor-plan').attr("width", floormap_width);
		$('.js-wrap-floor-plan').attr("height", floormap_height);
		$('.js-wrap-floor-plan').css({ "top": image.offsetTop });
		$('.js-wrap-floor-plan').css({ "left": 10 });
		$('.js-wrap-floor-plan').css({ "right": 10 });
		$('.js-wrap-floor-plan').css({ "bottom": image.offsetTop });

		$('.js-wrap-floor-plan').show();

		$canvasRound.width(floormap_width);
		$canvasRound.height(floormap_height);

		$canvas.attr("width", $canvasRound.width() + "px");
		$canvas.attr("height", $canvasRound.height() + "px");
		canvas = document.getElementById("floor-plan");
		context = canvas.getContext("2d");
		context.strokeStyle = "#15a1b1";
		offsetX = $canvas.offset().left;
		offsetY = $canvas.offset().top;

		//floormap_spinner.stop();

		$('.floormap-overlay').fadeOut();
		jsobj_rebuild_queue.splice(0,1);

		widthCanvas = $("#floor-plan").width();
		heightCanvas = $("#floor-plan").height();

		// restore plot
		var floormap_tag = null;
		$.each(obj.krpano.layer, function(index, elem) {
			if (elem.name == "map") {
				floormap_tag = elem;
				return false;
			}
		});
		// restore link
		var scenes = obj.krpano.scene;

		if (scenes != null) {
			if (obj.krpano.scenedraft != null) {
				scenes = scenes.concat(obj.krpano.scenedraft);
			}
		}

		for (var i = 0; i < scenes.length; i++)  {
			uploaded_spheres.push({
				id : scenes[i].name.replace(/scene[0-9][0-9]_/g,""),
				equiThumbnail_uri : scenes[i].thumburl,
				equirectangular_uri : scenes[i].image.sphere.url,
				isUploaded : true,
				telopcontent : "",
				title : scenes[i].title,
				hlookat : scenes[i].view.hlookat,
				vlookat : scenes[i].view.vlookat
			});
			var sphereId = scenes[i].name.replace(/scene[0-9][0-9]_/g,"");
			var telop = getTelop(obj.krpano, sphereId);
			getUploadedSphere(sphereId).telopcontent = telop;
		}

		var plots_tag = floormap_tag.layer;
		for (var i = 0; i < plots_tag.length; i++) {
			var x = plots_tag[i].x;
			var y = plots_tag[i].y;
			var id = plots_tag[i].name.slice(7);
			var plot = createPlotInfo(id, x * plot_scale , y * plot_scale);
			var arc_initial_direction = getArcInitialDirection(obj.krpano.scene, id);
			plot.startAngle = arc_initial_direction;
			var idString = parseInt(plots_tag[i].name.substr(4,2));
			plot.text = idString + 1;
			plots.push(plot);
			storedArc.push({
				x: plot.x,
				y: plot.y,
				startAngle: arc_initial_direction,
				active: false
			});
		}

		$.each(scenes, function(i, scene) {
			var scene_id = scene.name.replace(/scene[0-9][0-9]_/g,"");

			if (error_spheres.indexOf(scene_id) != -1){
				return true;
			}

			if (scene.hotspot != null) {
				$.each(scene.hotspot, function(i, hotspot) {
					if (hotspot != null) {
						var linked_scene_id = hotspot.linkedscene.replace(/scene[0-9][0-9]_/g,"");
                        var hotspotposition = calcHotSpotPosition(scene_id, linked_scene_id);
                        var ath = hotspotposition.ath;
                        var atv = hotspotposition.atv;
                        var hlookat = hotspotposition.hlookat;
                        if (!isDuplicatedLinkedPlot(scene_id, linked_scene_id)) {
                            var linked_plot = createLinkInfo(scene_id);
                            linked_plot.end = linked_scene_id;
                            linked_plot.x1 = getPlot(scene_id).x;
                            linked_plot.y1 = getPlot(scene_id).y;
                            linked_plot.x2 = getPlot(linked_scene_id).x;
                            linked_plot.y2 = getPlot(linked_scene_id).y;
                            linked_plot.color = "#494949";
                            if(ath != hotspot.ath || atv != hotspot.atv){
                                linked_plot.hotspot_forward_ath = hotspot.ath;
                                linked_plot.hotspot_forward_atv = hotspot.atv;
                            }
                            linked_plots.push(linked_plot);
                        } else {
                            var linked_plot = getDuplicatedLinkedPlot(scene_id, linked_scene_id);
                            if(ath != hotspot.ath || atv != hotspot.atv){
                                linked_plot.hotspot_reverse_ath = hotspot.ath;
                                linked_plot.hotspot_reverse_atv = hotspot.atv;
                            }
                        }

						// var line = {
						// 	start: scene_id,
						// 	end: linked_scene_id,
						// 	x1: getPlot(scene_id).x,
						// 	y1: getPlot(scene_id).y,
						// 	x2: getPlot(linked_scene_id).x,
						// 	y2: getPlot(linked_scene_id).y,
						// 	color: "#494949"
						// };
						// if (!checkLinesExist(line)) {
						// 	linked_plots.push(line);
						// }
					}
				});
			}

		});

		// restore sphere list

		for (i in uploaded_spheres) {
			var sphere = uploaded_spheres[i];
			if(sphere.title == null) {
				sphere.title = "";
			}

			var sphere_title = sphere.title;

			insertSphere(sphere.id, sphere.equiThumbnail_uri, sphere_title);

			$("#" + sphere.id).addClass("uploaded");

			$("#" + sphere.id + " img").attr("draggable", true);

			$("#" + sphere.id ).removeClass("unsortable");

			$(".js-scroll-area").addClass("sphere-container");

			$(".js-drop-spheres").children('.ot-message').css({
				'display': 'none'
			});

		}
		insertPlotNumber();
		reDraw();
	};
	image.src = floorMapUrl;
}

// get scene by tag name
function getSceneTagByName(scenes, name) {
	for (i in scenes) {
		scene = scenes[i];

		if (scene != null) {

			var scene_id = scene.name.replace(/scene[0-9][0-9]_/g, "");
			if (scene_id == name) {
				return scene;
			}
		}
	}
	return null;
}

// get arc by image vr id
function getArcInitialDirection(scenes, name) {
	var scene = getSceneTagByName(scenes, name);

	if (scene != null) {
		var onstart = scene.onstart;

		var str = onstart.match(/activatespot.*?;/i)[0];

		var str = str.match(/\(.+?\)/)[0].replace(/\(/, "").replace(/\)/, "");

		var angle = str.split(",")[1];

		var arc_initial_direction = (angle - arc_angle / 2 - 90 + (getUploadedSphere(name).hlookat % 360)) * Math.PI / 180;

		console.log("angle: " + angle);
		console.log("arc_initial_direction: " + arc_initial_direction);

		return arc_initial_direction;

	} else {
		return null;
	}
}

// get caption by image vr
function getTelop(krpano, name) {
	var scene = getSceneTagByName(obj.krpano.scene, name)
	if (scene == null) {
		scene = getSceneTagByName(obj.krpano.scenedraft, name);
	}

	if (scene != null) {
		var onstart = scene.onstart;

		var str;
		var result="";
		if(onstart.match(/settelop\(.*?\);/i)) {
			str = onstart.match(/settelop\(.*?\);/i)[0];
			result = str.split(",")[0];
			result = result.substr(9);
		}

		result = result.replace( /0x0027/g , "'" ) ;
		result = result.replace( /0x0022/g , '"' ) ;
		result = result.replace( /0x002C/g , ',' ) ;
		result = result.replace( /0x003C/g , '<' ) ;
		result = result.replace( /0x003E/g , '>' ) ;
		result = result.replace( /0x005B/g , '[' ) ;
		result = result.replace( /0x005D/g , ']' ) ;
		result = result.replace( /0x0026/g , '&' ) ;

		return result;

	} else {
		return "";
	}
}

//start restore edit tour
var restoreScreenLoader = {
    links_and_plots_completed : false,
    annotations_completed : false,
    bottom_completed : false,
    uploaded_spheres_completed : false,
    startRestoreScreen : function() {
        restoreAll();
        during_restore = false;
    }
}
// check have to edit tour
if (during_restore) {
	restoreScreenLoader.startRestoreScreen();
}
// parse json to object of config tour
if($('.ot-tour-config').val()) {
    var obj = JSON.parse($('.ot-tour-config').val());
}
