var MultiSelect = (function (GLOB) {
	// Добавить элементы в поле назначения:
	function moveItems(btn, srcSelect, dstSelect) {
		btn.onclick	= function () {
            var i;
			for (i = srcSelect.options.length - 1; i >= 0; i -= 1) {
				if (srcSelect.options[i].selected) {
					dstSelect.add(new Option(srcSelect.options[i].text, srcSelect.options[i].value));
					srcSelect.remove(i);
				}
			}
		};
	}
	// Подготовка данных к отправке:
	function formSubmit(element) {
		// Ф-ция делает все элеметы спика select выбраными:		
		function makeSelect(element) {
            var i;
			for (i = 0; i < element.options.length; i += 1) {
				element.options[i].selected = true;
			}
		}
		// Ниже мы всего лишь кроссбрауз. устанавливаем слушатель
		// события отправки формы:
		if (GLOB.document.addEventListener) {
			element.form.addEventListener("submit", function () {
				makeSelect(element);
			}, true);
		} else if (GLOB.document.attachEvent) {
			element.form.attachEvent("onsubmit", function () {
				makeSelect(element);
			});
		} else {
			element.form.onsubmit = function () {
				makeSelect(element);
			};
		}
	}
	return function (srcSelect, dstSelect, takeBtn, dropBtn) {
		return {
			init : function (srcSelect, dstSelect, takeBtn, dropBtn) {
				moveItems(takeBtn, srcSelect, dstSelect);
				moveItems(dropBtn, dstSelect, srcSelect);
				formSubmit(dstSelect);
			}
		}.init(srcSelect, dstSelect, takeBtn, dropBtn);
	};
}(this));