// pre made functions
const $ = s => document.querySelector(s);
const $$ = s => document.querySelectorAll(s);

// inner Html

Element.prototype.html = html;
NodeList.prototype.html = html;

function html(c = null) {
  const elm = this;

  if (c) {
    if (elm instanceof Element) {
      elm.innerHTML = c;
    } else if (elm instanceof NodeList) {
      elm.forEach(e => {
        e.innerHTML = c;
      })
    }
  } else {
    return elm.innerHTML;
  }

}

// inner text

Element.prototype.text = text;
NodeList.prototype.text = text;

function text(c = null) {
  const elm = this;

  if (c) {
    if (elm instanceof Element) {
      elm.innerText = c;
    } else if (elm instanceof NodeList) {
      elm.forEach(e => {
        e.innerText = c;
      })
    }
  } else {
    return elm.innerText;
  }
}


// addClass 
Element.prototype.addClass = addClass;
NodeList.prototype.addClass = addClass;

function addClass(c) {
  const elm = this;

  if (typeof c !== 'string') {
    console.error('Class names should be a string.');
    return elm;
  }

  cl = c.split(' ')

  if (elm instanceof Element) {
    cl.forEach(cls => {
      elm.classList.add(cls);
    })
  } else if (elm instanceof NodeList) {
    elm.forEach(el => {
      cl.forEach(cls => {
        el.classList.add(cls);
      })
    });
  } else {
    console.error('Invalid context for addClass');
    return null;
  }

  return elm;
}

// remove Class

Element.prototype.removeClass = removeClass;
NodeList.prototype.removeClass = removeClass;

function removeClass(c) {
  const elm = this;

  if (typeof c !== 'string') {
    console.error('Class names should be a string.');
    return elm;
  }

  cl = c.split(' ');

  if (elm instanceof Element) {
    cl.forEach(cls => {
      elm.classList.remove(cls);
    })
  } else if (elm instanceof NodeList) {
    elm.forEach(el => {
      cl.forEach(cls => {
        el.classList.remove(c);
      })
    });
  } else {
    console.error('Invalid context for removeClass');
    return null;
  }

  return elm;
}

// toggle Class

Element.prototype.toggleClass = toggleClass;
NodeList.prototype.toggleClass = toggleClass;

function toggleClass(c) {
  const elm = this;

  if (typeof c !== 'string') {
    console.error('Class names should be a string.');
    return elm;
  }

  cl = c.split(' ');

  if (elm instanceof Element) {
    cl.forEach(cls => {
      elm.classList.toggle(c);
    })
  } else if (elm instanceof NodeList) {
    elm.forEach(el => {
      cl.forEach(cls => {
        el.classList.toggle(c);
      })
    });
  } else {
    console.error('Invalid context for removeClass');
    return null;
  }

  return elm;
}


// has Class
Element.prototype.hasClass = function (c) {
  return this.classList.contains(c);
};




// ancestors and siblings

// Find single child
Element.prototype.find = find;
NodeList.prototype.find = find;

function find(c) {
  if (!this) {
    console.error('Element or NodeList does not exist');
    return null;
  }

  if (this instanceof Element) {
    return this.querySelector(c);
  } else if (this instanceof NodeList) {
    return this.querySelectorAll(c);
  } else {
    console.error('Invalid context for find');
    return null;
  }
}

// Find multiple children
Element.prototype.findMultiple = children;
NodeList.prototype.findMultiple = children;

function children(c) {
  if (!this) {
    console.error('Element or NodeList does not exist');
    return null;
  }

  if (this instanceof Element) {
    return this.querySelectorAll(c);
  } else if (this instanceof NodeList) {
    let results = [];
    this.forEach(element => {
      results = results.concat(Array.from(element.querySelectorAll(c)));
    });
    return results;
  } else {
    console.error('Invalid context for children');
    return null;
  }
}

// Find siblings
Element.prototype.siblings = siblings;
NodeList.prototype.siblings = siblings;

function siblings(c) {
  if (!this) {
    console.error('Element or NodeList does not exist');
    return null;
  }

  const siblingsArray = [];
  if (this instanceof Element) {
    let sibling = this.parentNode.firstElementChild;
    while (sibling) {
      if (sibling !== this && (!c || sibling.matches(c))) {
        siblingsArray.push(sibling);
      }
      sibling = sibling.nextElementSibling;
    }
  } else if (this instanceof NodeList) {
    this.forEach(element => {
      let sibling = element.parentNode.firstElementChild;
      while (sibling) {
        if (sibling !== element && (!c || sibling.matches(c))) {
          siblingsArray.push(sibling);
        }
        sibling = sibling.nextElementSibling;
      }
    });
  } else {
    console.error('Invalid context for siblings');
    return null;
  }

  return siblingsArray;
}

// Find parent
Element.prototype.parent = parent;
NodeList.prototype.parent = parent;

function parent(c) {
  if (!this) {
    console.error('Element or NodeList does not exist');
    return null;
  }

  if (this instanceof Element) {
    if (c) {
      let parent = this.parentElement;
      while (parent && !parent.matches(c)) {
        parent = parent.parentElement;
      }
      return parent;
    } else {
      return this.parentElement;
    }
  } else if (this instanceof NodeList) {
    const parentsArray = [];
    this.forEach(element => {
      if (c) {
        let parent = element.parentElement;
        while (parent && !parent.matches(c)) {
          parent = parent.parentElement;
        }
        if (parent) {
          parentsArray.push(parent);
        }
      } else {
        if (element.parentElement) {
          parentsArray.push(element.parentElement);
        }
      }
    });
    return parentsArray;
  } else {
    console.error('Invalid context for parent');
    return null;
  }
}

// attribute
Element.prototype.attr = attr;
NodeList.prototype.attr = attr;

function attr(attribute, value) {
  if (!this) {
    console.log('element does not exist');
    return null;
  }

  // Helper function to set attributes
  const setAttributes = (el, attributes) => {
    for (let key in attributes) {
      if (attributes[key] === null) {
        el.removeAttribute(key);
      } else {
        el.setAttribute(key, attributes[key]);
      }
    }
  };

  // Handle single element
  if (this instanceof Element) {
    if (typeof attribute === 'object') {
      // Set multiple attributes
      setAttributes(this, attribute);
    } else if (value === undefined) {
      // Get attribute
      return this.getAttribute(attribute);
    } else if (value === null) {
      // Remove attribute
      this.removeAttribute(attribute);
    } else {
      // Set single attribute
      this.setAttribute(attribute, value);
    }
    return this;
  }

  // Handle NodeList
  if (this instanceof NodeList || this instanceof HTMLCollection) {
    this.forEach(element => {
      if (typeof attribute === 'object') {
        // Set multiple attributes
        setAttributes(element, attribute);
      } else if (value === null) {
        // Remove attribute
        element.removeAttribute(attribute);
      } else {
        // Set single attribute
        element.setAttribute(attribute, value);
      }
    });
    return this;
  }
}

// event delegation
function globalListener(type, selector, callback, parent = document) {
  parent.addEventListener(type, e => {
    if (e.target.matches(selector)) {
      callback(e);
    }
  })
}

// delegation usage
// globalListener(
//   'click', 
//   '.box', 
//   e => {
//     e.target.classList.toggle('class');
//   },
//   $('any-selector')
// )

// make empty 

const makeEmpty = (elm, time = 0) => {
  if (time === 0) {
    elm.innerHTML = '';
  } else {
    setTimeout(() => {
      elm.innerHTML = '';
    }, time)
  }

}

function loadTab(tab) {
  $(tab).siblings().forEach(s => s.addClass('hidden'));
  $(tab).removeClass('hidden');
}

document.addEventListener('DOMContentLoaded', () => {
  // feature hide show
  document.addEventListener('click', (e) => {
    const isClickBtn = e.target.closest('[data-event="click"]');
    const currentTargetElm = e.target.closest('[data-group]')?.find('[data-action]');

    const isITabBtn = e.target.closest('[data-itab-btn]');
    const targetITab = isITabBtn?.find('[data-itab]');

    if (!isITabBtn && targetITab) return;
    if (isITabBtn) {
      console.log(isITabBtn);
      console.log(targetITab);
      toggleITab(targetITab);

      $$('[data-itab="expand"]').forEach(elm => {
        if (elm !== targetITab) {
          elm.style.width = '0px';
          elm.attr('data-itab', 'not-expand');
        }
      })
    }

    if (!isClickBtn && currentTargetElm) return;
    if (isClickBtn) {
      let isActive = false;

      if (currentTargetElm.attr('data-action') === 'hide' || currentTargetElm.attr('data-action') === 'show') {
        isActive = toggleHideShow(currentTargetElm);
      }

      if (currentTargetElm.attr('data-action') === 'collapsed' || currentTargetElm.attr('data-action') === 'open') {
        isActive = toggleOpenCollapse(currentTargetElm);
      }

      isClickBtn.attr('aria-expanded', isActive);
      isClickBtn.find('.arrow-down')?.toggleClass('-rotate-180');
    }
    $$('[data-action="show"]').forEach(elm => {
      if (elm !== currentTargetElm) {
        elm.attr('data-action', "hide");
        pwd(elm);
      }
    })

    $$('[data-action="open"]').forEach(elm => {
      if (elm !== currentTargetElm) {
        elm.style.height = '0px';
        elm.attr('data-action', 'collapsed');
        pwd(elm);
      }
    })

  })


  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      $$('[data-action="show"]').forEach(elm => {
        elm.attr('data-action', "hide");
        pwd(elm);
      })

      $$('[data-action="open"]').forEach(elm => {
        elm.style.height = '0px';
        elm.attr('data-action', 'collapsed');
        pwd(elm);
      })

    }
  })

  const pwd = (elm) => {
    const eventBtn = elm.closest('[data-group]')?.find('[data-event]');
    if (eventBtn) {
      eventBtn.attr('aria-expanded', 'false');
      eventBtn?.find('.arrow-down')?.removeClass('-rotate-180');
    }
  }

  const toggleHideShow = (element) => {
    if (element.attr('data-action') === 'hide') {
      element.attr('data-action', 'show');
      return true;
    } else if (element.attr('data-action') === 'show') {
      element.attr('data-action', 'hide');
      return false;
    }
  };


  const toggleOpenCollapse = (element) => {
    if (element.attr('data-action') === 'collapsed') {
      element.style.height = element.scrollHeight + 'px';
      element.attr('data-action', 'open');
      return true;
    } else if (element.attr('data-action') === 'open') {
      element.style.height = '0px';
      element.attr('data-action', 'collapsed');
      return false;
    }
  }

  const toggleITab = (element) => {
    if (element.attr('data-itab') === 'not-expand') {
      element.style.width = element.scrollWidth + 'px';
      element.attr('data-itab', 'expand');
      return true;
    } else if (element.attr('data-itab') === 'expand') {
      element.style.width = '0px';
      element.attr('data-itab', 'not-expand');
      return false;
    }
  }

  // modals

  const openModalButtons = $$('[data-modal-target]')
  const closeModalButtons = $$('[data-close-button]')
  const overlay = $('#overlay')

  openModalButtons.forEach(button => {
    button.addEventListener('click', () => {
      const modal = document.querySelector(button.dataset.modalTarget)
      openModal(modal)
    })
  })

  overlay.addEventListener('click', () => {
    const modals = document.querySelectorAll('.modal.active')
    modals.forEach(modal => {
      closeModal(modal)
    })
  })

  closeModalButtons.forEach(button => {
    button.addEventListener('click', () => {
      const modal = button.closest('.modal')
      closeModal(modal)
    })
  })

  function openModal(modal) {
    if (modal == null) return
    modal.addClass('active')
    overlay.addClass('active')
  }

  function closeModal(modal) {
    if (modal == null) return
    modal.removeClass('active')
    overlay.removeClass('active')
  }


  // drag and drop for sort

  const draggables = document.querySelectorAll('[data-draggable]');
  const dropContainers = document.querySelectorAll('[drop-container]');

  draggables.forEach(draggable => {
    draggable.addEventListener('dragstart', () => {
      draggable.addClass('opacity-50');
    });

    draggable.addEventListener('dragend', () => {
      draggable.removeClass('opacity-50');
    });
  });

  dropContainers.forEach(container => {
    container.addEventListener('dragover', e => {
      e.preventDefault();
      const draggable = document.querySelector('.opacity-50');
      if (isValidDrop(container, draggable)) {
        const afterElement = getDragAfterElement(container, e.clientY);
        if (afterElement == null) {
          container.appendChild(draggable);
        } else {
          container.insertBefore(draggable, afterElement);
        }
      }
    });
  });

  function getDragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll('[data-draggable]:not(.opacity-50)')]

    return draggableElements.reduce((closest, child) => {
      const box = child.getBoundingClientRect()
      const offset = y - box.top - box.height / 2
      if (offset < 0 && offset > closest.offset) {
        return { offset: offset, element: child }
      } else {
        return closest
      }
    }, { offset: Number.NEGATIVE_INFINITY }).element
  }

  function isValidDrop(container, draggable) {
    if (container.getAttribute('drop-container') === draggable.getAttribute('data-draggable')) {
      return true;
    }
    return false;
  }

  function isValidDrag(draggable, event) {
    if (draggable.attr()) {
      // Check if the drag is initiated on a child element of 'items' that is not draggable
      const child = event.target.closest('[data-draggable]');
      return child === draggable;
    }
  
    // Allow drag for elements with class 'img'
    if (draggable.classList.contains('img')) {
      return true;
    }
  
    return false;
  }

  //  draggable slider
  const slTabs = $$('.scrollable-tabs-container');
  slTabs.forEach(slt => {
    const tabs = slt.findMultiple(".scrollable-tabs-container li");
    const rightArrow = slt.find(
      "[data-arrow-right]"
    );
    const leftArrow = slt.find(
      '[data-arrow-left]'
    );
    const tabsList = slt.find(".scrollable-tabs-container ul, .sbrd-ul");
    const leftArrowContainer = slt.find(
      ".scrollable-tabs-container .left-arrow"
    );
    const rightArrowContainer = slt.find(
      ".scrollable-tabs-container .right-arrow"
    );

    const removeAllActiveClasses = () => {
      tabs.forEach((tab) => {
        tab.removeClass("active");
      });
    };

    tabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        removeAllActiveClasses();
        tab.addClass("active");
      });
    });

    const manageIcons = () => {
      if (tabsList.scrollLeft >= 20) {
        leftArrowContainer.addClass("active");
      } else {
        leftArrowContainer.removeClass("active");
      }

      let maxScrollValue = tabsList.scrollWidth - tabsList.clientWidth - 20;

      if (tabsList.scrollLeft >= maxScrollValue) {
        rightArrowContainer.removeClass("active");
      } else {
        rightArrowContainer.addClass("active");
      }
    };

    rightArrow.addEventListener("click", () => {
      tabsList.scrollLeft += 200;
      manageIcons();
    });

    leftArrow.addEventListener("click", () => {
      tabsList.scrollLeft -= 200;
      manageIcons();
    });

    tabsList.addEventListener("scroll", manageIcons);

    let dragging = false;

    const drag = (e) => {
      if (!dragging) return;
      tabsList.addClass("dragging");
      tabsList.scrollLeft -= e.movementX;
    };

    tabsList.addEventListener("mousedown", () => {
      dragging = true;
    });

    tabsList.addEventListener("mousemove", drag);

    document.addEventListener("mouseup", () => {
      dragging = false;
      tabsList.removeClass("dragging");
    });
  })

});


