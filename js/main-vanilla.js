var propertyType  = null;
var projectId     = null;
var roomType      = null;
var roomSize      = null;
var floor         = null;
var unitId        = null;

// Using event delegation https://gomakethings.com/why-event-delegation-is-a-better-way-to-listen-for-events-in-vanilla-js/#web-performance
document.addEventListener(
  "click",
  function(event) {
    // Mobile Menu Toggle
    if (event.target.matches(".site-toggle")) {
      if (event.target.classList.contains("active")) {
        removeClass(".site-toggle, .site-nav-m", "active");
        removeClass("#page", "show-nav");
      } else {
        addClass(".site-toggle, .site-nav-m", "active");
        addClass("#page", "show-nav");
      }
    }
    if (event.target.matches("#site-nav-m .menu-item-has-children i")) {
      if (event.target.parentNode.classList.contains("active")) {
        event.target.parentNode.classList.remove("active");
      } else {
        event.target.parentNode.classList.add("active");
      }
    }
    // Close menu on click (useful for One Page Website)
    if (event.target.matches("#site-nav-m a")) {
      if (event.target.getAttribute("href") == "#") {
        if (event.target.parentNode.classList.contains("active")) {
          event.target.parentNode.classList.remove("active");
        } else {
          event.target.parentNode.classList.add("active");
        }
      } else {
        removeClass(".site-toggle, .site-nav-m", "active");
      }
    }
    if (event.target.matches(".room-type")) {
      event.preventDefault();
      removeClass(".room-type", "active");
      event.target.classList.add("active");
      roomType = event.target.getAttribute('data-term-id');
      getUnitData(false, true, false, false, false, true);
    }
    if (event.target.matches("#custom-select-size ul li")) {
      roomSize = event.target.getAttribute('data-value');
      getUnitData(false, false, true, false, false, false);
    }
    if (event.target.matches("#custom-select-floor ul li")) {
      floor = event.target.getAttribute('data-value');
      getUnitData(false, false, false, true, false, false);
    }
    if (event.target.matches("#custom-select-unit ul li")) {
      unitId = event.target.getAttribute('data-value');
      getUnitData(false, false, false, false, true, false);
    }
  },
  false
);

document.addEventListener("DOMContentLoaded", function() {
  propertyType  = document.querySelector('.option-roomtype').getAttribute('data-property-type');
  projectId     = document.querySelector('.single-area').getAttribute('data-project-id');
  getUnitData();
});

function getUnitData(roomTypeLoad = true, roomSizeLoad = true, floorLoad = true, unitLoad = true, unitDetailLoad = true, reset = true) {

  if(reset == true) {
    floor   = null;
    unitId  = null;

    document.getElementById('custom-select-floor').remove();
    document.getElementById('custom-select-unit').remove();

    document.getElementById('select-floor').innerHTML         = '<option value="">&nbsp;</option>';
    document.getElementById('select-unit').innerHTML          = '<option value="">&nbsp;</option>';

    var floorSelect = new CustomSelect({
      elem: 'select-floor'
    });

    var unitSelect = new CustomSelect({
      elem: 'select-unit'
    });

    document.getElementById('label-direction').innerHTML      = '';
    document.getElementById('label-price').innerHTML          = '';
    document.getElementById('label-unit').innerHTML           = '';
    document.getElementById('label-size').innerHTML           = '';
    document.getElementById('label-unit-price').innerHTML     = '';
    document.getElementById('pic-floorplan').innerHTML        = '';
    document.getElementById('label-promotion').innerHTML      = '';
    document.getElementById('label-reserve-price').innerHTML  = '';
    document.getElementById('label-contract').innerHTML       = '';
    document.getElementById('label-deposit-price').innerHTML  = '';
    document.getElementById('label-deposit-period').innerHTML = '';
    document.getElementById('label-transfer').innerHTML       = '';
    document.getElementById('label-per-period').innerHTML     = '';
  }

  var roomTypeQuery   = (roomType !== null) ? `&room_type=${roomType}` : '';
  var roomSizeQuery   = (roomSize !== null) ? `&room_size=${roomSize}` : '';
  var floorQuery      = (floor !== null) ? `&floor=${floor}` : '';
  var unitQuery       = (unitId !== null) ? `&unit_id=${unitId}` : '';

  var request = new XMLHttpRequest();
  request.open('GET', `/wp-json/risland/v1/project/${projectId}?items=all${roomTypeQuery}${roomSizeQuery}${floorQuery}${unitQuery}`, true);

  request.onload = function() {
    if (this.status >= 200 && this.status < 400) {
      // Success!
      var data = JSON.parse(this.response);

      if(roomTypeLoad === true) {
        var roomTypeItems = '';
        data.room_types.forEach(function (item) {
          roomTypeItems += `<li><a href="#" class="room-type" data-term-id="${item.id}">${item.name}</a></li>`;
        });
        document.getElementById('room-type').innerHTML = roomTypeItems;
      }

      if(roomType !== null && roomSizeLoad == true) {
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

      if(roomType !== null && floorLoad == true) {
        var floorItems = '';
        document.getElementById('custom-select-floor').remove();
        floorItems += `<option value="">เลือกชั้น</option>`;
        data.floors.forEach(function (item) {
          floorItems += `<option value="${item}">${item}</option>`;
        });
        document.getElementById('select-floor').innerHTML = floorItems;
        var floorSelect = new CustomSelect({
          elem: 'select-floor'
        });
      }

      if(roomType !== null && unitLoad == true) {
        var unitItems = '';
        document.getElementById('custom-select-unit').remove();
        unitItems += `<option value="">เลือกยูนิต</option>`;
        data.items.forEach(function (item) {
          unitItems += `<option value="${item.id}">${item.title}</option>`;
        });
        document.getElementById('select-unit').innerHTML = unitItems;
        var unitSelect = new CustomSelect({
          elem: 'select-unit'
        });
      }

      if(roomType !== null && unitDetailLoad == true) {
        console.log(data.items);
        document.getElementById('label-direction').innerHTML      = data.items[0].direction[0];
        document.getElementById('label-price').innerHTML          = data.items[0].price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
        document.getElementById('label-per-period').innerHTML     = data.items[0].per_period.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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

// Mobile Menu - Add Dropdown Toggle
document.querySelectorAll("#site-nav-m .menu-item-has-children").forEach(e => {
  e.insertAdjacentHTML("beforeend", '<i class="si-caret-down"></i>');
});

// Slider
var sliders = document.querySelectorAll(".s-slider");
if (sliders) {
  for (var i = 0, len = sliders.length; i < len; i++) {
    var slider = sliders[i];
    if (slider.classList.contains("-togrid")) {
      var flkty = new Flickity(slider, {
        cellAlign: "left",
        contain: true,
        wrapAround: true,
        imagesLoaded: true,
        dragThreshold: 3,
        watchCSS: true
      });
    } else {
      var flkty = new Flickity(slider, {
        cellAlign: "left",
        contain: true,
        wrapAround: true,
        imagesLoaded: true,
        dragThreshold: 3
      });
    }
  }
}
// Fix iOS13 flickity performance - https://gist.github.com/bakura10/b0647ef412eb7757fa6f0d2c74c1f145
(function() {
  let touchingCarousel = false,
    touchStartCoords;
  document.body.addEventListener("touchstart", function(e) {
    if (e.target.closest(".flickity-slider")) {
      touchingCarousel = true;
    } else {
      touchingCarousel = false;
      return;
    }
    touchStartCoords = {
      x: e.touches[0].pageX,
      y: e.touches[0].pageY
    };
  });
  document.body.addEventListener(
    "touchmove",
    function(e) {
      if (!(touchingCarousel && e.cancelable)) {
        return;
      }
      let moveVector = {
        x: e.touches[0].pageX - touchStartCoords.x,
        y: e.touches[0].pageY - touchStartCoords.y
      };
      if (Math.abs(moveVector.x) > 5) e.preventDefault();
    },
    { passive: false }
  );
})();

// Scroll and Show Site Header on Home Page
if (document.body.classList.contains("home")) {
  var header = document.querySelector("#masthead");
  var header_scroll = header.getAttribute("data-scroll");
  if (!header_scroll) {
    header_scroll = 300;
  }
  window.onscroll = function changeClass() {
    var scroll = window.pageYOffset | document.body.scrollTop;
    if (scroll > header_scroll) {
      addClass(".site-header", "-active");
      removeClass(".site-header", "-not-active");
    } else if (scroll <= 300) {
      addClass(".site-header", "-not-active");
      removeClass(".site-header", "-active");
    }
  };
}

// Auto Show Header on scroll - https://www.sysleaf.com/js-toggle-header-on-scroll/
var lastKnownScrollY = 0;
var currentScrollY = 0;
var ticking = false;
var idOfHeader = "masthead";
var eleHeader = null;
var height = 50;
const classes = {
  pinned: "-show",
  unpinned: "-hide"
};
function onScroll() {
  currentScrollY = window.pageYOffset;
  if (currentScrollY > height) {
    requestTick();
  }
}
function requestTick() {
  if (!ticking) {
    requestAnimationFrame(update);
  }
  ticking = true;
}
function update() {
  if (currentScrollY < lastKnownScrollY) {
    pin();
  } else if (currentScrollY > lastKnownScrollY) {
    unpin();
  }
  lastKnownScrollY = currentScrollY;
  ticking = false;
}
function pin() {
  if (eleHeader.classList.contains(classes.unpinned)) {
    eleHeader.classList.remove(classes.unpinned);
    eleHeader.classList.add(classes.pinned);
  }
}
function unpin() {
  if (eleHeader.classList.contains(classes.pinned) || !eleHeader.classList.contains(classes.unpinned)) {
    eleHeader.classList.remove(classes.pinned);
    eleHeader.classList.add(classes.unpinned);
  }
}
window.onload = function() {
  eleHeader = document.getElementById(idOfHeader);
  if (eleHeader.classList.contains("-overlay")) {
    height = 0;
  } else {
    height = eleHeader.offsetHeight;
  }
  document.addEventListener("scroll", onScroll, false);
};

var sizeSelect = new CustomSelect({
  elem: 'select-size'
});

var floorSelect = new CustomSelect({
  elem: 'select-floor'
});

var unitSelect = new CustomSelect({
  elem: 'select-unit'
});