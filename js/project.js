var propertyType  = null;
var projectId     = null;
var roomType      = null;
var roomSize      = null;
var floor         = null;
var unitId        = null;

var md = new MobileDetect(window.navigator.userAgent);

if(md.mobile() == null) {
  var sidebar = new StickySidebar('#rightbar', {topSpacing: 80});
}

document.addEventListener(
    "click",
    function(event) {
        if (event.target.matches(".room-type")) {
            event.preventDefault();
            removeClass(".room-type", "active");
            event.target.classList.add("active");
            roomType = event.target.getAttribute('data-term-id');
            roomSize = null;
            floor = null;
            unitId = null;
            getUnitData(false, true, false, false, false, true);
        }
        if (event.target.matches("#custom-select-size ul li")) {
            roomSize = event.target.getAttribute('data-value');
            floor = null;
            unitId = null;
            getUnitData(false, false, true, false, true, true);
        }
        if (event.target.matches("#custom-select-floor ul li")) {
            floor = event.target.getAttribute('data-value');
            unitId = null;
            getUnitData(false, false, false, true, false, false);
        }
        if (event.target.matches("#custom-select-unit ul li")) {
            unitId = event.target.getAttribute('data-value');
            getUnitData(false, false, false, false, true, false);
        }
        // if (event.target.matches("#btn-booking")) {
        //   event.preventDefault();
        //   console.log(unitId);
        // }
    },
    false
);

document.addEventListener("DOMContentLoaded", function() {
  
    var propertyTypeSelector  = document.querySelector('.option-roomtype');
    var projectIdSelector     = document.querySelector('.single-area');
  
    if(propertyTypeSelector) {
      propertyType  = propertyTypeSelector.getAttribute('data-property-type');
    }
  
    if(projectIdSelector) {
      projectId     = projectIdSelector.getAttribute('data-project-id');
    }

    var sizeSelect = new CustomSelect({
      elem: 'select-size'
    });
    
    if(propertyType == 'condominium') {
      var floorSelect = new CustomSelect({
        elem: 'select-floor'
      });
    }
      
    var unitSelect = new CustomSelect({
      elem: 'select-unit'
    });
  
    getUnitData();
});
  
function getUnitData(roomTypeLoad = true, roomSizeLoad = true, floorLoad = true, unitLoad = true, unitDetailLoad = true, reset = true) {
  
    if(reset == true) {
      floor   = null;
      unitId  = null;
  
      if(propertyType == 'condominium') {
        var floorSelector = document.getElementById('custom-select-floor');
        if(floorSelector) {
          document.getElementById('custom-select-floor').remove();
          document.getElementById('select-floor').innerHTML = '<option value="">&nbsp;</option>';
          var floorSelect = new CustomSelect({
            elem: 'select-floor'
          });
        }
      }
  
      var unitSelector  = document.getElementById('custom-select-unit');
      if(unitSelector) {
        document.getElementById('custom-select-unit').remove();
        document.getElementById('select-unit').innerHTML = '<option value="">&nbsp;</option>';
        var unitSelect = new CustomSelect({
          elem: 'select-unit'
        });
      }
  
      var labelDirection = document.getElementById('label-direction');
      if(labelDirection) {
        document.getElementById('label-direction').innerHTML = '';
      }
  
      var labelPrice = document.getElementById('label-price');
      if(labelPrice) {
        document.getElementById('label-price').innerHTML = '';
      }
  
      var labelUnit = document.getElementById('label-unit');
      if(labelUnit) {
        document.getElementById('label-unit').innerHTML = '';
      }
  
      var labelSize = document.getElementById('label-size');
      if(labelSize) {
        document.getElementById('label-size').innerHTML = '';
      }
  
      var labelUnitPrice = document.getElementById('label-unit-price');
      if(labelUnitPrice) {
        document.getElementById('label-unit-price').innerHTML = '';
      }
  
      var picFloorPlan = document.getElementById('pic-floorplan');
      if(picFloorPlan) {
        document.getElementById('pic-floorplan').innerHTML = '';
      }
  
      var labelPromotion = document.getElementById('label-promotion');
      if(labelPromotion) {
        document.getElementById('label-promotion').innerHTML = '';
      }
      
      var labelReservePrice = document.getElementById('label-reserve-price');
      if(labelReservePrice) {
        document.getElementById('label-reserve-price').innerHTML = '';
      }
  
      var labelContract = document.getElementById('label-contract');
      if(labelContract) {
        document.getElementById('label-contract').innerHTML = '';
      }
  
      var labelDepositPrice = document.getElementById('label-deposit-price');
      if(labelDepositPrice) {
        document.getElementById('label-deposit-price').innerHTML = '';
      }
  
      var labelDepositPeriod = document.getElementById('label-deposit-period');
      if(labelDepositPeriod) {
        document.getElementById('label-deposit-period').innerHTML = '';
      }
  
      var labelTransfer = document.getElementById('label-transfer');
      if(labelTransfer) {
        document.getElementById('label-transfer').innerHTML = '';
      }
  
      var labelPerPeriod = document.getElementById('label-per-period');
      if(labelPerPeriod) {
        document.getElementById('label-per-period').innerHTML = '';
      }
    
    }
  
    var roomTypeQuery   = (roomType !== null) ? `&room_type=${roomType}` : '';
    var roomSizeQuery   = (roomSize !== null) ? `&room_size=${roomSize}` : '';
    var floorQuery      = (floor !== null) ? `&floor=${floor}` : '';
    var unitQuery       = (unitId !== null) ? `&unit_id=${unitId}` : '';
  
    var request = new XMLHttpRequest();
    request.open('GET', `/wp-json/risland/v1/project/${projectId}?items=all${roomTypeQuery}${roomSizeQuery}${floorQuery}${unitQuery}`, true);

    console.log(`/wp-json/risland/v1/project/${projectId}?items=all${roomTypeQuery}${roomSizeQuery}${floorQuery}${unitQuery}`);
  
    request.onload = function() {
      if (this.status >= 200 && this.status < 400) {
        // Success!
        var data = JSON.parse(this.response);
  
        if(roomTypeLoad === true) {
          var roomTypeItems = '<li>กรุณาเลือก</li>';
          data.room_types.forEach(function (item) {
            roomTypeItems += `<li><a href="#" class="room-type" data-term-id="${item.id}">${item.name}</a></li>`;
          });
          document.getElementById('room-type').innerHTML = roomTypeItems;
          addClass(".option-content.-top", "-show");
        }
  
        if(roomType !== null && roomSizeLoad == true) {
          addClass(".option-content.-detail", "-show");
          var roomSizeItems = '';
          document.getElementById('custom-select-size').remove();
          roomSizeItems += `<option value="">เลือกขนาด</option>`;
          data.room_sizes.forEach(function (item) {
            roomSizeItems += `<option value="${item.id}">${item.name} ตร.ม.</option>`;
          });
          document.getElementById('select-size').innerHTML = roomSizeItems;
          var sizeSelect = new CustomSelect({
            elem: 'select-size'
          });
        }
  
        if(roomType !== null && floorLoad == true && propertyType == 'condominium') {
          var floorItems = '';
          document.getElementById('custom-select-floor').remove();
          floorItems += `<option value="">เลือกชั้น</option>`;
          data.floors.forEach(function (item) {
            floorItems += `<option value="${item.id}">${item.name}</option>`;
          });
          document.getElementById('select-floor').innerHTML = floorItems;
          var floorSelect = new CustomSelect({
            elem: 'select-floor'
          });
        }
  
        if((roomType !== null && unitLoad == true && propertyType == 'condominium') || (roomType !== null && propertyType == 'home' && floorLoad == true)) {
          var unitItems = '';
          document.getElementById('custom-select-unit').remove();
          unitItems += `<option value="">เลือกยูนิต</option>`;
          data.items.forEach(function (item) {
            unitItems += `<option value="${item.id}">${item.title}</option>`;
          });
          if(data.items) {
            addClass(".content-waiting", "-show");
          }
          document.getElementById('select-unit').innerHTML = unitItems;
          var unitSelect = new CustomSelect({
            elem: 'select-unit'
          });
        }
  
        if(roomType !== null && unitDetailLoad == true) {
          console.log(data.items);
          document.getElementById("btn-booking").href               = `/checkout/?add-to-cart=${data.items[0].id}`;
          document.getElementById('label-direction').innerHTML      = data.items[0].direction[0];
          document.getElementById('label-price').innerHTML          = `${data.items[0].price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")} บาท`;
          document.getElementById('label-unit').innerHTML           = data.items[0].title;
          document.getElementById('label-size').innerHTML           = data.items[0].room_size[0].name;
          document.getElementById('label-unit-price').innerHTML     = data.items[0].unit_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          if(data.items[0].floor_plan) {
            document.getElementById('pic-floorplan').innerHTML      = `<img src="${data.items[0].floor_plan.url}" alt="${data.items[0].floor_plan.title}" />`;
          }
          document.getElementById('label-promotion').innerHTML      = data.items[0].promotion;
          document.getElementById('label-reserve-price').innerHTML  = data.items[0].reserve_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          document.getElementById('label-contract').innerHTML       = data.items[0].contract.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          document.getElementById('label-deposit-price').innerHTML  = data.items[0].deposit_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          document.getElementById('label-deposit-period').innerHTML = `${data.items[0].deposit_period} งวด`;
          document.getElementById('label-transfer').innerHTML       = data.items[0].transfer.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          // document.getElementById('label-per-period').innerHTML     = data.items[0].per_period.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

          var dataPerPeriod = '';
          data.items[0].per_period.forEach(function (item) {
            dataPerPeriod += `<div class="item">
                <div class="label">${item.name}</div>
                <div class="pricing">${item.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</div>
            </div>`;
          });
          document.getElementById('label-per-period').innerHTML     = dataPerPeriod;
        }
  
      } else {
        // We reached our target server, but it returned an error
  
      }
    };
  
    request.onerror = function() {
      // There was a connection error of some sort
    };
  
    request.send();
}