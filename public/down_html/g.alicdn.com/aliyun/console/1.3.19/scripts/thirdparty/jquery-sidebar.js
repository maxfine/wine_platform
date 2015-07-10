/*!
 * jQuery Aliyun Console Sidebar
 * wenheng http://gitlab.alibaba-inc.com/aliyun/console
 */

;
(function (window) {

  var SUFFIX = getSUFFIX();
  /**
   * Used by Sidebar, and can be overwrite.
   * @property SUFFIX      : hostname SUFFIX, eg. .test or .com
   * @property defaultData : used for SidebarInfo request failed
   * @property productId   : 产品ID,eg,ecs,rds.
   */
  var SIDEBAR_CONFIG = {
    SUFFIX: SUFFIX,
    defaultData: getDefaultData(),
    productId: null,
    appendNode:".viewFramework-sidebar",
    requestUrl: {
      sidebarInfo: "//home.console.aliyun" + SUFFIX + "/center/Sidebar.js",
      readMessage: "//home.console.aliyun" + SUFFIX + "/center/updateMessageInfo.js"
    }
  };

  var sidebarNode,wrapNode;

  if (!window.jQuery) {
    throw("jQuery is NEED for aliyun console Sidebar. Recommand 1.10.2");
    return;
  }

  var $ = window.jQuery;

  if (window.SIDEBAR_CONFIG) {
    $.extend(SIDEBAR_CONFIG, window.SIDEBAR_CONFIG);
  }

  getSidebarInfo();

  function getSUFFIX() {
    var domain = window.location.hostname;
    if (!domain.match(/^.+\.aliyun\.|^aliyun\./))return '.com';
    var output = domain.replace(/^.*\.aliyun|^aliyun/i, '');
    if (!output)output = '.com';
    return output;
  };

  function getDefaultData() {
    return {
      "title": ['云产品', '用户中心'],
      "products": [
        {
          "icon": "icon-ecs-3",
          "id": "ecs",
          "title": "云服务器",
          "url": "http://console.aliyun" + SUFFIX + "/index.htm"
        },
        {
          "icon": "icon-rds-3",
          "id": "rds",
          "title": "云数据库",
          "url": "http://rds.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-slb-3",
          "id": "slb",
          "title": "负载均衡",
          "url": "http://slb.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-oss-3",
          "id": "oss",
          "title": "开放存储服务",
          "url": "http://oss.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-cdn-3",
          "id": "cdn",
          "title": "内容分发网络",
          "url": "http://cdn.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-ots-3",
          "id": "ots",
          "title": "开放结构化数据服务",
          "url": "http://ots.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-ocs-3",
          "id": "ocs",
          "title": "开放缓存服务",
          "url": "http://ocs.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-odps-3",
          "id": "odps",
          "title": "开放数据处理服务",
          "url": "http://odps.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-ace-3",
          "id": "ace",
          "title": "云引擎",
          "url": "http://ace.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-yundun-3",
          "id": "yundun",
          "title": "云盾",
          "url": "http://yundun.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-sls-3",
          "id": "sls",
          "title": "简单日志服务",
          "url": "http://sls.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-mqs-3",
          "id": "mqs",
          "title": "消息队列服务",
          "url": "http://mqs.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-opensearch-3",
          "id": "opensearch",
          "title": "开放搜索服务",
          "url": "http://opensearch.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-pts-3",
          "id": "pts",
          "title": "性能测试服务",
          "url": "http://pts.console.aliyun" + SUFFIX
        }
      ],
      "productsPicked": ["ecs", "rds", "slb"],
      "services": [
        {
          "icon": "icon-account-2",
          "id": "account",
          "isOldVersion": true,
          "title": "帐户管理",
          "url": "https://account.aliyun" + SUFFIX + "/profile/profile.htm"
        },
        {
          "icon": "icon-expense",
          "id": "expenseCenter",
          "title": "费用中心",
          "url": "http://expense.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-renew",
          "id": "renew",
          "title": "续费管理",
          "url": "http://renew.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-invite",
          "id": "msc",
          "title": "消息中心",
          "url": "https://msc.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-pen",
          "id": "workorder",
          "title": "工单管理",
          "url": "http://workorder.console.aliyun" + SUFFIX
        },
        {
          "icon": "icon-bsn",
          "id": "bsn",
          "title": "备案管理",
          "url": "http://bsn.aliyun" + SUFFIX
        }
      ],
      "servicesPicked": ["account", "expenseCenter", "renew"]
    };
  }

  function openDialog(index) {
    if (index === 1) {
      $('.modal-backdrop').eq(index - 1).css('display', 'block');
      $('.viewFramework-sidebar-dialog').eq(index - 1).css('display', 'block');
    } else if (index === 2) {
      $('.modal-backdrop').eq(index - 1).css('display', 'block');
      $('.viewFramework-sidebar-dialog').eq(index - 1).css('display', 'block');
    }
  }

  function getDialogTemplate(data, index) {
    var dataList, dataListPicked;
    var DIALOG_CONIG = ['自定义云产品快捷入口', '自定义用户中心快捷入口'];
    var dialogHtml = '<div class="modal-backdrop fade in" style="z-index: 1040;font-size:12px;display:none;"></div>' +
      '<div class="modal fade viewFramework-sidebar-dialog in" style="z-index: 1050; display: none;">' +
      '<div class="modal-dialog">' +
      '<div class="modal-content">' +
      '<div class="viewFramework-sidebar-manage">' +
      '<div class="modal-header">' +
      '<button type="button" class="close">' +
      '×' +
      '</button>' +
      '<h5 class="modal-title">' + DIALOG_CONIG[index - 1] + '</h5></div>' +
      '<div class="modal-body">' +
      '<div class="sidebar-config-title ng-binding">' +
      '已选区域:' +
      '</div>' +
      '<div class="sidebar-item-list sidebar-item-list-picked clearfix" id="sidebar-item-list-picked1">instead pickedcontent</div>' +
      '<div class="sidebar-config-gap"></div>' +
      '<div class="sidebar-config-title ng-binding"">可选区域:</div>' +
      '<div class="sidebar-item-list sidebar-item-list-unpick clearfix" id="sidebar-item-list-unpick1">instead unpickcontent</div>' +
      '</div>' +
      '<div class="modal-footer"><button class="btn btn-primary">确定</button><button class="btn btn-default">取消</button></div>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>';
    var dialogPickedList = '';
    var dialogUnpickList = '';
    if (index === 1) {
      dataList = data.products;
      dataListPicked = data.productsPicked;
    } else if (index === 2) {
      dataList = data.services;
      dataListPicked = data.servicesPicked;
    }
    for (var i = 0; i < dataList.length; i++) {
      var item = dataList[i];
      if (isCon(dataListPicked, item.id)) {
        var pickedListItem = '<div class="sidebar-item-wrap">' +
          '<div class="sidebar-item">' +
          '<span class="sidebar-item-icon ' + item.icon + '"></span> ' +
          '<span class="sidebar-item-text ng-binding">' + item.title + '&nbsp;' + item.id + '</span>' +
          '<span class="sidebar-item-opt-icon icon-no" ng-click="clickHandler(item)"></span>' +
          '</div>' +
          '</div>';
        dialogPickedList += pickedListItem;
      } else if (!isCon(dataListPicked, item.id)) {
        var unpickListItem = '<div class="sidebar-item-wrap">' +
          '<div class="sidebar-item">' +
          '<span class="sidebar-item-icon ' + item.icon + '"></span> ' +
          '<span class="sidebar-item-text ng-binding">' + item.title + '&nbsp;' + item.id + '</span> ' +
          '<span class="sidebar-item-opt-icon icon-add"></span>' +
          '</div></div>';
        dialogUnpickList += unpickListItem;
      }

    }


    var combinedPicked = dialogHtml.split('instead pickedcontent');
    var combinedUnpick = combinedPicked[1].split('instead unpickcontent');
    dialogHtml = combinedPicked[0] + dialogPickedList + combinedUnpick[0] + dialogUnpickList + combinedUnpick[1];


    return dialogHtml;

  }

  function getSidebarTemplate(data) {
    var sidebarHtml =
      '<div>' +
      '<div class="sidebar-content">' +
      '<div class="sidebar-nav main-nav">' +
      '</div>' +
      '</div>' +
      '</div>'
    var htmlNode = $(sidebarHtml);
    var navNode = htmlNode.find('.sidebar-nav');
    navNode.append(getTitleTemplate(data, 1));
    navNode.append(getNavTemplate(data, 1));
    navNode.append(getTitleTemplate(data, 2));
    navNode.append(getNavTemplate(data, 2));
    navNode.append(getDialogTemplate(data, 1));
    navNode.append(getDialogTemplate(data, 2));
    $(document).ready(function () {
      $(SIDEBAR_CONFIG.appendNode).append(htmlNode);
      sidebarNode = $(SIDEBAR_CONFIG.appendNode);
      wrapNode = $(SIDEBAR_CONFIG.appendNode).parent();
      wrapNode.addClass("viewFramework-sidebar-mini");
    });


    bindAllEvent(data);
  }

  function showTooltip(X, Y, item) {
    if (!($(wrapNode).hasClass('viewFramework-sidebar-mini'))) {
      return false;
    };
    var TooltipHtml = '<div class="aliyun-console-sidebar-tooltip right fade in animateTooltip" style="left:' + (parseInt(X) + 50) + 'px;top: ' + Y + 'px; z-index:100001;display: block">' +
      '<div class="tooltip-arrow"></div>' +
      '<div class="tooltip-inner">' + item + '</div>' +
      '</div>';
    var TooltipNode = $(TooltipHtml);
    $('body').append(TooltipNode);
    return TooltipNode;
  }

  function hideTooltip(item) {
    if (item != false) {
      item.remove();
    }

  }

  function bindAllEvent(data) {
    var navTitle = $('.nav-title');
    var TooltipController;

    $('#sidebar-title1').on('click', function () {
      $('#sidebar-nav1').toggle();
    }).on('mouseenter', function (e) {
      var offset = $(e.target).offset();
      offsetX = offset.left;
      offsetY = offset.top;
      TooltipController = showTooltip(offsetX, offsetY, '云产品');
    }).on('mouseleave', function () {
      hideTooltip(TooltipController);
    });
    $('#sidebar-title2').on('click', function () {
      $('#sidebar-nav2').toggle();
    }).on('mouseenter', function (e) {
      var offset = $(e.target).offset();
      offsetX = offset.left;
      offsetY = offset.top;
      TooltipController = showTooltip(offsetX, offsetY, '用户中心');
    }).on('mouseleave', function () {
      hideTooltip(TooltipController);
    });
    ;

    $('#sidebar-mini').on('click', function () {
      wrapNode.removeClass('viewFramework-sidebar-full');
      wrapNode.addClass('viewFramework-sidebar-mini');
    });
    $('#sidebar-full').on('click', function () {
      wrapNode.removeClass('viewFramework-sidebar-mini');
      wrapNode.addClass('viewFramework-sidebar-full');
    });

    $('.icon-setup').each(function (index) {
      $(this).on('click', function (event) {
        event.stopPropagation();
        openDialog(index + 1);
        updateDialogList(data, index);
      })
    });
    $('.modal-header>button,.modal-footer>.btn-default').on('click', function () {
      $('#sidebar-item-list-picked1 .sidebar-item-opt-icon').each(function () {
        $(this).off('click');
      });
      $('#sidebar-item-list-unpick1 .sidebar-item-opt-icon').each(function () {
        $(this).off('click');
      });
      $('.modal-backdrop').css('display', 'none');
      $('.viewFramework-sidebar-dialog').css('display', 'none');
    });
    $('.modal-footer>.btn-primary').each(function (index) {
      $(this).on('click', function () {
        $("#sidebar-nav" + (index + 1)).replaceWith(getNavTemplate(data, index + 1));
        navBindEvent();
        $('#sidebar-item-list-picked1 .sidebar-item-opt-icon').each(function () {
          $(this).off('click');
        });
        $('#sidebar-item-list-unpick1 .sidebar-item-opt-icon').each(function () {
          $(this).off('click');
        });
        $('.modal-backdrop').css('display', 'none');
        $('.viewFramework-sidebar-dialog').css('display', 'none');
      })
    });
    navBindEvent();

  }

  function navBindEvent() {
    var TooltipController;
    $(sidebarNode).find("li").each(function () {
      var TooltipText = $(this).find('.nav-title').text();

      $(this).on('mouseenter', function () {
        var offset = $(this).offset();
        var offsetX = offset.left;
        var offsetY = offset.top;
        TooltipController = showTooltip(offsetX, offsetY, TooltipText);
      }).on('mouseleave', function () {
        hideTooltip(TooltipController);
      })

    });
  }

  function bindUnpickEvent(currentItemNode, data, index) {
    var currentUnpickItem;
    if (index === 0) {
      dataList = data.products;
      dataListPicked = data.productsPicked;
    } else if (index === 1) {
      dataList = data.services;
      dataListPicked = data.servicesPicked;
    }
    var currentId = currentItemNode.find('.sidebar-item-text').text().match(/[a-z]+/i)[0];
    for (var i = 0; i < dataList.length; i++) {
      var item = dataList[i];
      if (item.id === currentId) {
        currentUnpickItem = item;
      }
    }
    addArrayItem(dataListPicked, currentId);
    var currentNode = $('<div class="sidebar-item-wrap">' +
    '<div class="sidebar-item">' +
    '<span class="sidebar-item-icon ' + currentUnpickItem.icon + '"></span> ' +
    '<span class="sidebar-item-text ng-binding">' + currentUnpickItem.title + '&nbsp;' + currentUnpickItem.id + '</span> ' +
    '<span class="sidebar-item-opt-icon icon-no"></span>' +
    '</div></div>');

    currentNode.on('click', function () {
      bindPickedEvent(currentNode, data, index);
    });
    $('.modal-body').eq(index).find('#sidebar-item-list-picked1').append(currentNode);
    currentItemNode.remove();

  }

  function bindPickedEvent(currentItemNode, data, index) {
    var currentpickedItem;
    console.log(index);
    if (index === 0) {
      dataList = data.products;
      dataListPicked = data.productsPicked;
    } else if (index === 1) {
      dataList = data.services;
      dataListPicked = data.servicesPicked;
    }
    var currentId = currentItemNode.find('.sidebar-item-text').text().match(/[a-z]+/i)[0];
    console.log(currentId);
    for (var i = 0; i < dataList.length; i++) {
      var item = dataList[i];
      if (item.id === currentId) {
        currentpickedItem = item;
      }
    }
    deleteArrayItem(data.servicesPicked, currentId);
    var currentNode = $('<div class="sidebar-item-wrap">' +
    '<div class="sidebar-item">' +
    '<span class="sidebar-item-icon ' + currentpickedItem.icon + '"></span> ' +
    '<span class="sidebar-item-text ng-binding">' + currentpickedItem.title + '&nbsp;' + currentpickedItem.id + '</span> ' +
    '<span class="sidebar-item-opt-icon icon-add"></span>' +
    '</div></div>');

    currentNode.on('click', function () {
      bindUnpickEvent(currentNode, data, index);
    });
    $('.modal-body').eq(index).find('#sidebar-item-list-unpick1').append(currentNode);
    currentItemNode.remove();
  }

  function updateDialogList(data, index) {
    var currentPickedItem, currentUnpickItem;
    if (index === 0) {
      $('.modal-body').eq(index).find($('#sidebar-item-list-picked1 .sidebar-item-opt-icon')).each(function () {
        $(this).on('click', function () {
          var currentId = $(this).parent().find('.sidebar-item-text').text().match(/[a-z]+/i)[0];
          for (var i = 0; i < data.products.length; i++) {
            var product = data.products[i];
            if (product.id === currentId) {
              currentPickedItem = product;
            }
          }
          deleteArrayItem(data.productsPicked, currentId);
          var currentNode = $('<div class="sidebar-item-wrap">' +
          '<div class="sidebar-item">' +
          '<span class="sidebar-item-icon ' + currentPickedItem.icon + '"></span> ' +
          '<span class="sidebar-item-text ng-binding">' + currentPickedItem.title + '&nbsp;' + currentPickedItem.id + '</span> ' +
          '<span class="sidebar-item-opt-icon icon-add"></span>' +
          '</div></div>');

          currentNode.on('click', function () {
            bindUnpickEvent(currentNode, data, index);
          });
          $('.modal-body').eq(index).find('#sidebar-item-list-unpick1').append(currentNode);
          $(this).parent().parent().remove();
        });
      });

      $('#sidebar-item-list-unpick1 .sidebar-item-opt-icon').each(function () {
        $(this).on('click', function () {
          var currentId = $(this).parent().find('.sidebar-item-text').text().match(/[a-z]+/i)[0];
          for (var i = 0; i < data.products.length; i++) {
            var product = data.products[i];
            if (product.id === currentId) {
              currentUnpickItem = product;
            }
          }
          addArrayItem(data.productsPicked, currentId);
          var currentNode = $('<div class="sidebar-item-wrap">' +
          '<div class="sidebar-item">' +
          '<span class="sidebar-item-icon ' + currentUnpickItem.icon + '"></span> ' +
          '<span class="sidebar-item-text ng-binding">' + currentUnpickItem.title + '&nbsp;' + currentUnpickItem.id + '</span> ' +
          '<span class="sidebar-item-opt-icon icon-no"></span>' +
          '</div></div>');

          currentNode.on('click', function () {
            bindPickedEvent(currentNode, data, index);
          })
          $('.modal-body').eq(index).find('#sidebar-item-list-picked1').append(currentNode);
          $(this).parent().parent().remove();
        });
      });
    } else if (index === 1) {
      $('.modal-body').eq(index).find($('#sidebar-item-list-picked1 .sidebar-item-opt-icon')).each(function () {
        $(this).on('click', function () {
          var currentId = $(this).parent().find('.sidebar-item-text').text().match(/[a-z]+/i)[0];
          for (var i = 0; i < data.services.length; i++) {
            var service = data.services[i];
            if (service.id === currentId) {
              currentPickedItem = service;
            }
          }
          deleteArrayItem(data.servicesPicked, currentId);
          var currentNode = $('<div class="sidebar-item-wrap">' +
          '<div class="sidebar-item">' +
          '<span class="sidebar-item-icon ' + currentPickedItem.icon + '"></span> ' +
          '<span class="sidebar-item-text ng-binding">' + currentPickedItem.title + '&nbsp;' + currentPickedItem.id + '</span> ' +
          '<span class="sidebar-item-opt-icon icon-add"></span>' +
          '</div></div>');

          currentNode.on('click', function () {
            bindUnpickEvent(currentNode, data, index);
          });
          $('.modal-body').eq(index).find('#sidebar-item-list-unpick1').append(currentNode);
          $(this).parent().parent().remove();
        });
      });

      $('#sidebar-item-list-unpick1 .sidebar-item-opt-icon').each(function () {
        $(this).on('click', function () {
          var currentId = $(this).parent().find('.sidebar-item-text').text().match(/[a-z]+/i)[0];
          for (var i = 0; i < data.services.length; i++) {
            var service = data.services[i];
            if (service.id === currentId) {
              currentUnpickItem = service;
            }
          }
          addArrayItem(data.servicesPicked, currentId);
          var currentNode = $('<div class="sidebar-item-wrap">' +
          '<div class="sidebar-item">' +
          '<span class="sidebar-item-icon ' + currentUnpickItem.icon + '"></span> ' +
          '<span class="sidebar-item-text ng-binding">' + currentUnpickItem.title + '&nbsp;' + currentUnpickItem.id + '</span> ' +
          '<span class="sidebar-item-opt-icon icon-no"></span>' +
          '</div></div>');

          currentNode.on('click', function () {
            bindPickedEvent(currentNode, data, index);
          })
          $('.modal-body').eq(index).find('#sidebar-item-list-picked1').append(currentNode);
          $(this).parent().parent().remove();
        });
      });
    }

  }

  function getTitleTemplate(data, index) {
    var titleHtml = '<div class="sidebar-title" style="font-size:12px;" id="sidebar-title' + index + '">' +
      '<div class="sidebar-title-inner ng-scope">' +
      '<span class="sidebar-title-icon icon-arrow-down"></span><span class="sidebar-title-text ng-binding">' + data.title[index - 1] + '</span>' +
      '<span class="sidebar-manage ng-scope">' +
      '<a class="icon-setup"></a>' +
      '</span>' +
      '</div>' +
      '</div>';
    return titleHtml;
  }


  function getNavTemplate(data, index) {
    var navHtml = '<ul class="sidebar-trans" style="font-size:12px;" id="sidebar-nav' + index + '"></ul>';
    var navNode = $(navHtml);
    if (index === 1) {
      for (var i = 0; i < data.products.length; i++) {
        var product = data.products[i];
        if (isCon(data.productsPicked, product.id)) {
          navNode.append('<li>' +
          '<a href="' + product.url + '" class="sidebar-trans">' +
          '<div class="nav-icon sidebar-trans">' +
          '<span class="' + product.icon + '"></span>' +
          '</div>' +
          '<span class="nav-title ng-binding">' + product.title + '</span>' +
          '</a>' +
          '</li>')
        }

      }
    } else if (index === 2) {
      for (var i = 0; i < data.services.length; i++) {
        var service = data.services[i];
        if (isCon(data.servicesPicked, service.id)) {
          navNode.append('<li>' +
          '<a href="' + service.url + '" class="sidebar-trans ng-scope">' +
          '<div class="nav-icon sidebar-trans">' +
          '<span class="' + service.icon + '"></span>' +
          '</div>' +
          '<span class="nav-title ng-binding">' + service.title + '</span>' +
          '</a>' +
          '</li>')
        }
      }
    }

    return navNode;
  }

  function getSidebarInfo() {
    $.ajax(SIDEBAR_CONFIG.requestUrl.sidebarInfo, {
      dataType: "jsonp"
    })
      .done(function (result) {
        if (result && result.code == "200") {
          var data = result.data;
          var ra = data.productPreference;
          var rb = data.servicePreference;
          delete data.productPreference;
          delete data.servicePreference;
          data.productsPicked = ra;
          data.servicesPicked = rb;
          data.title = ['云产品', '用户中心'];

          SIDEBAR_CONFIG.defaultData = data;
        }
        getSidebarTemplate(SIDEBAR_CONFIG.defaultData);
      })
      .fail(function (result) {
        console.log("Get Sidebar info error.show default data");
        getSidebarTemplate(SIDEBAR_CONFIG.defaultData);
      });
  }

  function isCon(arr, val) {
    for (var i = 0; i < arr.length; i++) {
      if (arr[i] == val)
        return true;
    }
    return false;
  }

  function deleteArrayItem(arr, val) {
    for (var i = 0; i < arr.length; i++) {
      if (arr[i] === val) {
        arr.splice(i, 1);
      }
    }
  }

  function addArrayItem(arr, val) {
    arr.push(val);
  }

})(window);
