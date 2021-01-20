function __eval(code) {
  return Function('"use strict";return (' + code + ')')();
}

function __getCurrentValue(element) {
  return element.val().toString();
}

function __attachValidationHandler(input) {
  var rule = input.data("rule");
  if (typeof rule !== 'undefined' && rule.length > 0) {
    input.on("blur",
            function () {
                var current = __getCurrentValue(input);
                var code = rule.split("{val}").join("'" + current + "'");
                var result = __eval(code);
                if (result)
                    input.removeClass("is-invalid");
                else
                    input.addClass("is-invalid");
            });
  }
}

function __detachValidationHandler(input) {
  var rule = input.data("rule");
  if (typeof rule !== 'undefined' && rule.length > 0) {
    input.off("blur");
  }
}

function __triggerValidationHandler(input) {
  var rule = input.data("rule");
  if (typeof rule !== 'undefined' && rule.length > 0) {
    input.trigger("blur");
  }
}

function __isEmail(value) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(value);
}

function __isPhone(value) {
  var regex = /^([+]?[\s0-9]+)?(\d{3}|[(]?[0-9]+[)])?([-]?[\s]?[0-9])+$/;
  return regex.test(value);
}

function __isUrl(value) {
  var regex = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/;
  return regex.test(value);
}

function __isFloat(value) {
  var regex = /^[+-]?\d+(\.\d+)?$/;
  return regex.test(value);
}

function __isInt(value) {
  var regex = /^[+-]?\d+$/;
  return regex.test(value);
}

function __isChecked(selector) {
  return ($(selector).is(":checked"));
}

function __setDisabled(fields,val) {
  fields.forEach(function(item) {
        if ($(item).length>0) {
          var elementType = $(item)[0].nodeName.toLowerCase();
          switch(elementType) {
                case "select":
                  $(item)[0].disabled = val;
                  break;
                default:
                  $(item)[0].disabled = val;
          }
        }
  });

}

function __disableFields(fields) {
  __setDisabled(fields,true);
}

function __enableFields(fields) {
  __setDisabled(fields,false);
}

function __setCheckBoxes(fields,val) {
  fields.forEach(function(item) {
        if ($(item).length>0) {
          var elementType = $(item)[0].nodeName.toLowerCase();
          if (elementType==='checkbox') {
                $(item)[0].value = val;
                $(item)[0].checked = val;
          }
        }

  });
}

