/*!
 * jQuery Aliyun Console Topbar
 * liuqi.lq http://gitlab.alibaba-inc.com/aliyun/console
 */

;(function(window){

  var suffix = getSuffix();
  /**
   * Used by topbar, and can be overwrite.
   * @property suffix      : hostname suffix, eg. .test or .com
   * @property defaultData : used for topbarInfo request failed
   * @property productId   : 产品ID,eg,ecs,rds.
   * @property workorderId : 工单类别ID.产品workorder会自动从接口获取.
   * @property topbarSpm   : 黄金令箭C段埋点. 默认101
   */
  var TOPBAR_CONFIG = {
    suffix       :  suffix,
    defaultData  :  getDefaultData(),
    productId    :  null,
    workorderId  :  null,
    topbarSpm    :  "101",
    requestUrl   :  {
      topbarInfo : "//home.console.aliyun"+ suffix +"/center/topbar.js",
      readMessage: "//home.console.aliyun"+ suffix +"/center/updateMessageInfo.js"
    }
  };

  var topbarNode;

  if(!window.jQuery){
    throw("jQuery is NEED for aliyun console topbar. Recommand 1.10.2");
    return;
  }

  var $ = window.jQuery;

  if(window.TOPBAR_CONFIG){
    $.extend(TOPBAR_CONFIG,window.TOPBAR_CONFIG);
  }

  preTopbarRender();
  getTopbarInfo();

  function getSuffix(){
    var domain = window.location.hostname;
    if(!domain.match(/^.+\.aliyun\.|^aliyun\./))return '.com';
    var output =  domain.replace(/^.*\.aliyun|^aliyun/i,'');
    if(!output)output = '.com';
    return output;
  };

  function getDefaultData(){
    return {
      "categoryInfo": [
        {
          "products": [{
            "className": "icon-ecs",
            "href": "http://console.aliyun"+suffix+"/ecs/index.htm",
            "id": "ecs",
            "short": "ECS",
            "spm": 1,
            "status": true,
            "target": "_self",
            "text": "云服务器",
            "workorderId": "12"
          },
            {
              "className": "icon-slb",
              "href": "http://slb.console.aliyun"+suffix,
              "id": "slb",
              "short": "SLB",
              "spm": 2,
              "status": true,
              "target": "_self",
              "text": "负载均衡",
              "workorderId": "86"
            },
            {
              "className": "icon-vpc",
              "href": "http://home.console.aliyun"+suffix+"/vpcProtocol.html",
              "id": "vpc",
              "short": "VPC",
              "spm": 17,
              "status": false,
              "text": "专有网络"
            },
            {
              "className": "icon-ess",
              "href": "http://ess.console.aliyun"+suffix,
              "id": "ess",
              "short": "ESS",
              "spm": 18,
              "status": false,
              "target": "_self",
              "text": "弹性伸缩服务",
              "workorderId": ""
            }],
          "text": "弹性计算"
        },
        {
          "products": [{
            "className": "icon-rds",
            "href": "http://rds.console.aliyun"+suffix,
            "id": "rds",
            "short": "RDS",
            "spm": 3,
            "status": true,
            "target": "_self",
            "text": "云数据库",
            "workorderId": "10"
          },
            {
              "className": "icon-ots",
              "href": "http://ots.console.aliyun"+suffix,
              "id": "ots",
              "short": "OTS",
              "spm": 6,
              "status": true,
              "target": "_self",
              "text": "开放结构化数据服务",
              "workorderId": "29"
            },
            {
              "className": "icon-ocs",
              "href": "http://ocs.console.aliyun"+suffix,
              "id": "ocs",
              "short": "OCS",
              "spm": 7,
              "status": true,
              "target": "_self",
              "text": "开放缓存服务",
              "workorderId": "91"
            },
            {
              "className": "icon-drds",
              "href": "http://drds.console.aliyun"+suffix,
              "id": "drds",
              "short": "DRDS",
              "spm": 22,
              "status": false,
              "target": "_self",
              "text": "分布式关系型数据库",
              "workorderId": "1223"
            }],
          "text": "数据库"
        },
        {
          "products": [{
            "className": "icon-oss",
            "href": "http://oss.console.aliyun"+suffix+"/console/index",
            "id": "oss",
            "short": "OSS",
            "spm": 4,
            "status": true,
            "target": "_self",
            "text": "开放存储服务",
            "workorderId": "22"
          },
            {
              "className": "icon-cdn",
              "href": "http://cdn.console.aliyun"+suffix,
              "id": "cdn",
              "short": "CDN",
              "spm": 5,
              "status": true,
              "target": "_self",
              "text": "内容分发网络",
              "workorderId": "92"
            },
            {
              "className": "icon-oas",
              "href": "http://oas.console.aliyun"+suffix+"/console/index",
              "id": "oas",
              "short": "OAS",
              "spm": 14,
              "status": false,
              "target": "_self",
              "text": "开放归档服务",
              "workorderId": "1211"
            },
            {
              "className": "icon-redisa",
              "href": "https://kvstore.console.aliyun"+suffix,
              "id": "redisa",
              "short": "KVStore",
              "spm": 23,
              "status": true,
              "target": "_self",
              "text": "键值存储",
              "workorderId": "1226"
            }],
          "text": "存储与CDN"
        },
        {
          "products": [{
            "className": "icon-odps",
            "href": "http://odps.console.aliyun"+suffix+"/console/index",
            "id": "odps",
            "short": "ODPS",
            "spm": 8,
            "status": true,
            "target": "_self",
            "text": "开放数据处理服务",
            "workorderId": "47"
          },
            {
              "className": "icon-dpc",
              "href": "http://dpc.console.aliyun"+suffix+"/index.htm",
              "id": "dpc",
              "short": "DPC",
              "spm": 20,
              "status": false,
              "target": "_self",
              "text": "采云间",
              "workorderId": ""
            },
            {
              "className": "icon-ads",
              "href": "http://ads.console.aliyun"+suffix,
              "id": "ads",
              "short": "ADS",
              "spm": 21,
              "status": false,
              "target": "_self",
              "text": "分析数据库服务",
              "workorderId": "1220"
            }],
          "text": "大规模计算"
        },
        {
          "products": [{
            "className": "icon-ace",
            "href": "http://ace.console.aliyun"+suffix,
            "id": "ace",
            "short": "ACE",
            "spm": 9,
            "status": true,
            "target": "_self",
            "text": "云引擎",
            "workorderId": "18"
          },
            {
              "className": "icon-sls",
              "href": "http://sls.console.aliyun"+suffix,
              "id": "sls",
              "short": "SLS",
              "spm": 12,
              "status": true,
              "target": "_self",
              "text": "简单日志服务",
              "workorderId": "1210"
            },
            {
              "className": "icon-mqs",
              "href": "http://mqs.console.aliyun"+suffix,
              "id": "mqs",
              "short": "MQS",
              "spm": 13,
              "status": true,
              "target": "_self",
              "text": "消息队列服务",
              "workorderId": "1212"
            },
            {
              "className": "icon-opensearch",
              "href": "http://opensearch.console.aliyun"+suffix,
              "id": "opensearch",
              "short": "",
              "spm": 15,
              "status": true,
              "target": "_self",
              "text": "开放搜索服务",
              "workorderId": "1213"
            },
            {
              "className": "icon-pts",
              "href": "http://pts.aliyun"+suffix+"/aliyun",
              "id": "pts",
              "short": "PTS",
              "spm": 16,
              "status": false,
              "target": "_self",
              "text": "性能测试服务",
              "workorderId": "1216"
            },
            {
              "className": "icon-ons",
              "href": "http://ons.console.aliyun"+suffix,
              "id": "ons",
              "short": "ONS",
              "spm": 19,
              "status": false,
              "target": "_self",
              "text": "开放消息服务",
              "workorderId": "1217"
            }],
          "text": "应用服务"
        },
        {
          "products": [{
            "className": "icon-yundun",
            "href": "http://yundun.console.aliyun"+suffix,
            "id": "yundun",
            "short": "",
            "spm": 10,
            "status": true,
            "target": "_self",
            "text": "云盾",
            "workorderId": "80"
          },
            {
              "className": "icon-yunjiankong",
              "href": "http://console.aliyun"+suffix+"/jiankong/",
              "id": "jiankong",
              "short": "",
              "spm": 11,
              "status": true,
              "target": "_self",
              "text": "云监控",
              "workorderId": "90"
            }],
          "text": "安全与管理"
        }],
      "navLinks": {
        "entrances": [
          {
            "href": "https://ak-console.aliyun"+suffix,
            "target": "_blank",
            "text": "AccessKeys",
            "id":"accesskeys"
          },
          {
            "links": [{
              "href": "http://workorder.console.aliyun"+suffix,
              "target": "_blank",
              "text": "我的工单",
              "id":"workorderOwn"
            },
              {
                "href": "https://workorder.console.aliyun"+suffix+"/#/ticket/add?productId=",
                "hrefWithNoId": "https://workorder.console.aliyun"+suffix+"/#/ticket/createIndex",
                "target": "_blank",
                "text": "提交工单",
                "id":"workorderAdd"
              }],
            "text": "工单服务",
            "id":"workorder"
          },
          {
            "href": "http://beian.aliyun"+suffix,
            "target": "_blank",
            "text": "备案",
            "id":"beian"
          },
          {
            "href": "http://help.aliyun"+suffix,
            "target": "_blank",
            "text": "帮助中心",
            "id":"help"
          }],
        "homeLink":{
          "href":"http://home.console.aliyun.com",
          "icon":"icon-home",
          "target":"_self"
        },
        "logoLink": {
          "href": "http://www.aliyun"+suffix,
          "target": "_blank"
        },
        "notificationLink": {
          "blankText": "您暂时没有公告消息",
          "href": "https://msc.console.aliyun"+suffix,
          "messageUrl": "https://msc.console.aliyun"+suffix+"/#/innerMsg/allDetail/",
          "text": "查看更多",
          "title": "站内消息通知"
        },
        "productLink": {
          "text": "产品与服务"
        },
        "searchLink": {
          "href": "http://www.aliyun"+suffix+"/s?k=",
          "text": "全局搜索"
        },
        "userLink": {
          "links": [{
            "href": "https://account.aliyun"+suffix+"/logout/logout.htm?oauth_callback=",
            "target": "_self",
            "text": "退出"
          }]
        }
      }
    };
  }

  function preTopbarRender(){
    var topbarHtml = '<div class="aliyun-console-topbar"><div class="topbar-wrap topbar-clearfix"></div></div>';

    topbarNode = $(topbarHtml);

    $(document).ready(function(){
      $(document.body).prepend(topbarNode);
    });
  }

  function getTopbarTemplate(data){
    var navLinks = data.navLinks;
    if(!navLinks){
      return;
    }
    var wrapNode = topbarNode.find('.topbar-wrap');

    wrapNode.append(getLogoTemplate(navLinks));
    wrapNode.append(getNavTemplate(data));
    wrapNode.append(getInfoTemplate(data));

    wrapNode.find('.dropdown-toggle').each(function(index,element){
      addDropdownEvent($(element));
    });

  }

  function getLogoTemplate(navLinks){
    var logoLink = navLinks.logoLink;
    var homeLink = navLinks.homeLink;
    if(!logoLink) return;
    var htmlTpl = '<div class="topbar-head topbar-left"><a href="'+logoLink.href+'" target="'+(logoLink.target || '_blank') +'" class="topbar-logo topbar-left" data-spm-click="gostr=/aliyun;locaid=d1">'+
      '<span class="icon-logo2"></span>'+
    '</a><a href="'+homeLink.href+'" target="'+ (homeLink.target || '_blank')+'" class="topbar-home topbar-left" data-spm-click="gostr=/aliyun;locaid=d2">'+
      '<span class="'+homeLink.icon+'"></span>'+
    '</a></div>';
    return htmlTpl;
  }

  function getNavTemplate(data){
    var productLink = data.navLinks.productLink,
        categoryInfo = data.categoryInfo,
        productStatus = data.productStatus;
    var navTpl = '<div class="topbar-nav topbar-left dropdown">'+
      '<a href="#" class="dropdown-toggle topbar-btn topbar-nav-btn" data-toggle="dropdown" data-spm-click="gostr=/aliyun;locaid=d3">'+
      '<span>'+ productLink.text +'</span>'+
      '<span class="caret"></span>'+
    '</a>'+
    '<div class="dropdown-menu topbar-nav-list topbar-clearfix">'+
    '</div>'+
    '</div>';
    var navNode = $(navTpl),
      navListNode = navNode.find('.topbar-nav-list'),
      colResult = $('<div class="topbar-nav-col"></div>'),
      count = 0 ,
      length;
    if(categoryInfo && categoryInfo.length > 0){
      length = categoryInfo.length;
      for(var i = 0;i < length;i++){
        var category = categoryInfo[i];
        colResult.append(formatProductsInfo(category,productStatus,i%2==0));
        if(i % 2 == 1 || i == length -1){
          navListNode.append(colResult);
          colResult = $('<div class="topbar-nav-col"></div>');
        }
      }
    }
    return navNode;
  }

  function getInfoTemplate(data){
    var htmlTpl = '<div class="topbar-info topbar-right"><div class="topbar-left"></div><div class="topbar-right"></div></div>';
    var infoNode = $(htmlTpl);
    data.navLinks = formatNavLinks(data.navLinks);
    infoNode.find('.topbar-left').append(getSearchTemplate(data)).append(getNoticeTemplate(data));
    infoNode.find('.topbar-right').append(getEntranceTemplate(data)).append(getUserTemplate(data));
    return infoNode;
  }

  function getSearchTemplate(data){
    var searchLink = data.navLinks.searchLink;
    var searchTpl =
      '<div class="topbar-btn topbar-btn-search topbar-left" data-spm-click="gostr=/aliyun;locaid=d7">'+
      '<div class="aliyun-console-topbar-search">'+
      '<form name="form" role="form">'+
        '<input class="topbar-search-ask" type="text" name="input" autocomplete="off">'+
        '<a target="_blank" href="'+ searchLink.href +'" class="topbar-search-mark" aliyun-console-spm="3">'+
          '<span class="topbar-search-mark-icon icon-search"></span>'+
        '</a>'+
       '</form></div></div>';

    var searchNode = $(searchTpl),
      askNode = searchNode.find(".aliyun-console-topbar-search"),
      inputNode = searchNode.find('.topbar-search-ask'),
      markNode = searchNode.find('.topbar-search-mark'),
      markIcon = searchNode.find('.topbar-search-mark-icon');
    inputNode
      .on("focus",function(event){
        askNode.addClass("topbar-search-active");
        markIcon.attr("class","icon-enter");
      })
      .on("blur",function(){
        askNode.removeClass("topbar-search-active");
        markIcon.attr("class","icon-search");
      })
      .on('keyup',function(e){
        if(e.keyCode == 13){
          window.open(markNode.attr('href'), "_blank");
        }else{
          markNode.attr('href',searchLink.href + inputNode.val());
        }
      });
    return searchNode;
  }

  function getNoticeTemplate(data){
    var messageInfo = data.messageInfo;
    var notificationLink = data.navLinks.notificationLink;
    if(!messageInfo || !(messageInfo.total >=0)){
      return "";
    }
    var htmlTpl =
      '<div class="dropdown topbar-notice topbar-btn topbar-left">'+
        '<a href="#" class="dropdown-toggle topbar-btn-notice" data-toggle="dropdown" data-spm-click="gostr=/aliyun;locaid=d4">'+
          '<span class="topbar-btn-notice-icon icon-bell"></span>'+
          '<span class="topbar-btn-notice-num">'+ messageInfo.total+  '</span>'+
        '</a>'+
      '<div class="topbar-notice-panel">'+
        '<div class="topbar-notice-arrow"></div>'+
        '<div class="topbar-notice-head"><span>'+ notificationLink.title +'</span></div>'+
        '<div class="topbar-notice-body">';
    if(!messageInfo ||  messageInfo.messageList.length == 0){
      htmlTpl+= '<p ng-if="!messageInfo ||  messageInfo.messageList.length == 0" class="topbar-notice-empty">'+notificationLink.blankText+'</p>';
    }
    htmlTpl+=
      '</div>'+
      '<div class="topbar-notice-foot">'+
      '<a class="topbar-notice-more" target="_blank" href="'+ notificationLink.href+ '" data-spm-click="gostr=/aliyun;locaid=d401">'+ notificationLink.text +'</a>'+
    '</div>'+
    '</div>'+
    '</div>';
    var messageNode = $(htmlTpl);
    renderMessageInfo(messageNode,messageInfo,notificationLink);
    messageNode.on("click",'.topbar-notice-body li a',function(){
      updateMessageInfo();
    });
    return messageNode;
  }

  function renderMessageInfo(messageNode,messageInfo,notificationLink){
    if(!messageNode){
      return;
    }
    var messageListNode = messageNode.find('.topbar-notice-body');
    var htmlTpl;
    if(messageInfo && messageInfo.messageList && messageInfo.messageList.length > 0){
      htmlTpl = "<ul>";
      $.each(messageInfo.messageList,function(index,element){
        htmlTpl +=
          '<li>'+
          '<a href="'+ (notificationLink.messageUrl + element.msgId) +'" target="_blank" class="clearfix">'+
          '<span class="inline-block">'+
          '<span class="topbar-notice-link">'+ element.title +'</span>'+
          '<span class="topbar-notice-time">'+ element.formatCreatedTime +'</span>'+
          '</span>'+
          '<span class="inline-block topbar-notice-class">'+
          '<span class="topbar-notice-class-name">'+element.className+'</span>'+
          '</span>'+
          '</a>'+
          '</li>';
      });
      htmlTpl += "</ul>";
    }else{
      htmlTpl =  '<p class="topbar-notice-empty">'+ notificationLink.blankText + '</p>';
    }
    messageListNode.html(htmlTpl);
    if(messageInfo.total != undefined){
      messageNode.find('.topbar-btn-notice-num').text(messageInfo.total);
    }
  }

  function getEntranceTemplate(data){
    var entranceLinks = data.navLinks.entrances;
    var htmlTpl = "";
    $.each(entranceLinks,function(index,element){
      htmlTpl += '<div class="topbar-left">';
      if(index == 0 ){
        htmlTpl += '<span class="topbar-info-gap"></span>';
      }
      if(element.links){
        htmlTpl +=
          '<div class="dropdown topbar-info-item">'+
            '<a href="#"  class="dropdown-toggle topbar-btn" data-toggle="dropdown" data-spm-click="gostr=/aliyun;locaid=d5'+index+'"><span>'+ element.text +'</span><span class="icon-arrow-down"></span></a>'+
            '<ul class="dropdown-menu">';
        var dropdownLinks = "";
        $.each(element.links,function(i,link){
          dropdownLinks += '<li ng-repeat="link in entry.links" class="topbar-info-btn">'+
          '<a href="'+link.href+'" target="'+(link.target||'_blank')+'" data-spm-click="gostr=/aliyun;locaid=d5'+index+(1+'')+'"><span>'+ link.text +'</span></a></li>';
        });
        htmlTpl += dropdownLinks;
        htmlTpl += '</ul></div>';
      }else{
        htmlTpl += '<div class="topbar-info-item" ><a href="'+ element.href +'" target="'+ (element.target||'_blank') +'" class="topbar-btn" data-spm-click="gostr=/aliyun;locaid=d5'+index+'">'+element.text+'</a></div>'
      }
    });
    return htmlTpl;
  }

  function getUserTemplate(data){
    var userLink = data.navLinks.userLink;
    var account = data.account;
    var htmlTpl =
      '<div class="topbar-left">'+
        '<span class="topbar-info-gap"></span>'+
        '<div class="dropdown topbar-info-item">'+
        '<a href="#"  class="dropdown-toggle topbar-btn" data-toggle="dropdown"  data-spm-click="gostr=/aliyun;locaid=d6"><span>'+ (account?account.aliyunId:'') +'</span><span class="icon-arrow-down"></span></a>'+
        '<ul class="dropdown-menu">';
    if(userLink.links){
      $.each(userLink.links,function(index,element){
        htmlTpl += '<li class="topbar-info-btn">'+
          '<a href="'+ element.href +'" target="'+(element.target||'_blank')+'"><span>'+ element.text +'</span></a>'+
        '</li>';
      });
    }
    htmlTpl+= '</ul></div></div>';
    return htmlTpl;
  }

  function formatProductsInfo(category,productStatus,hasGap){
    var itemNode = jQuery('<div class="topbar-nav-item"><p class="topbar-nav-item-title">'+ category.text +'</p><ul></ul></div>'),
      itemList = itemNode.find('ul'),
      length = category.products.length;

    for(var i = 0;i < length;i ++){
      var product =  category.products[i];
      var productId = TOPBAR_CONFIG.productId;

      if(productId == product.id && TOPBAR_CONFIG.workorderId == null){
        TOPBAR_CONFIG.workorderId = product.workorderId;
      }
      var itemTemplate = [
        '<li data-spm-click="gostr=/aliyun;locaid=d30'+product.id+'">',
        '<a href=\"'+ product.href+'" target="'+ product.target + '">',
        '<span class="topbar-nav-item-icon '+ product.className+ '\"></span>',
        '<span>'+product.text+'</span>',
        '<span class="topbar-nav-item-short">' + product.short + '</span>',
        '</a>',
        '</li>'
      ].join("");
      var productNode = $(itemTemplate);

      if(productStatus == undefined ||  productStatus[product.id] == 0){
        productNode.addClass("topbar-unservice");
      }
      itemList.append(productNode);
    }
    if(hasGap){
      itemNode.append('<div class="topbar-nav-gap"></div>');
    }
    return itemNode;
  }

  var noopFun = function(){},
    openElement = null,
    closeMenu = noopFun;

  function addDropdownEvent(element){

    element.parent().on('click', function() { closeMenu(); });

    element.on('click', function (event) {

      var elementWasOpen = (element === openElement);

      event.preventDefault();
      event.stopPropagation();

      if (!!openElement) {
        closeMenu();
      }

      if (!elementWasOpen && !element.hasClass('disabled') && !element.prop('disabled')) {
        element.parent().addClass('open');
        openElement = element;
        closeMenu = function(event){
          if (event) {
            event.stopPropagation();
          }
          $(document).off('click', closeMenu);
          element.parent().removeClass('open');
          closeMenu = noopFun;
          openElement = null;
        };
        $(document).on('click', closeMenu);
      }
    });
  }

  function addHrefToLoginOutLink(href){
    return href + encodeURIComponent(window.location.href);
  }

  function formatNavLinks(navLinks){
    var userLink = navLinks.userLink;
    userLink && userLink.links && $.each(userLink.links,function(index,element){
      var href = element.href;
      if(/oauth_callback=$/.test(href)){
        element.href = addHrefToLoginOutLink(href);
      }
    });
    var workorderLink = getItemFromArrayByValue(navLinks.entrances,"workorder");
    if(workorderLink){
      var workorderLinkAdd = getItemFromArrayByValue(workorderLink.links,"workorderAdd");
      if(workorderLinkAdd){
        if(TOPBAR_CONFIG.workorderId){
          workorderLinkAdd.href = workorderLinkAdd.href + TOPBAR_CONFIG.workorderId;
        }else{
          workorderLinkAdd.hrefWithNoId && (workorderLinkAdd.href = workorderLinkAdd.hrefWithNoId);
        }
      }
    }
    return navLinks;
  }

  function getItemFromArrayByValue(list,value,key){
    if(!key) key = "id";
    var result = null;
    if($.isArray(list) && list.length > 0 && value){
      $.each(list,function(index,element){
        if(!result && element[key] == value){
          result = element;
        }
      });
    }
    return result;
  }

  function getTopbarInfo(){
    $.ajax(TOPBAR_CONFIG.requestUrl.topbarInfo, {
      dataType:"jsonp"
    })
      .done(function(result){
        if(result && result.code == "200"){
          TOPBAR_CONFIG.defaultData = result.data;
        }
        getTopbarTemplate(TOPBAR_CONFIG.defaultData);
      })
      .fail(function(result){
        console.log("Get topbar info error.show default data");
        getTopbarTemplate({"account":{"aliyunId":"hi20645116@aliyun.com"},"categoryInfo":[{"products":[{"className":"icon-ecs","href":"http://console.aliyun.com/ecs/index.htm","id":"ecs","short":"ECS","spm":1,"status":false,"target":"_self","text":"云服务器","workorderId":"12"},{"className":"icon-slb","href":"http://slb.console.aliyun.com","id":"slb","short":"SLB","spm":2,"status":false,"target":"_self","text":"负载均衡","workorderId":"86"},{"className":"icon-vpc","href":"http://home.console.aliyun.com/vpcProtocol.html","id":"vpc","short":"VPC","spm":17,"status":false,"text":"专有网络"},{"className":"icon-ess","href":"http://ess.console.aliyun.com","id":"ess","short":"ESS","spm":18,"status":false,"target":"_self","text":"弹性伸缩服务","workorderId":""}],"text":"弹性计算"},{"products":[{"className":"icon-rds","href":"http://rds.console.aliyun.com","id":"rds","short":"RDS","spm":3,"status":true,"target":"_self","text":"云数据库","workorderId":"10"},{"className":"icon-ots","href":"http://ots.console.aliyun.com/","id":"ots","short":"OTS","spm":6,"status":false,"target":"_self","text":"开放结构化数据服务","workorderId":"29"},{"className":"icon-ocs","href":"http://ocs.console.aliyun.com/","id":"ocs","short":"OCS","spm":7,"status":false,"target":"_self","text":"开放缓存服务","workorderId":"91"},{"className":"icon-drds","href":"http://drds.console.aliyun.com","id":"drds","short":"DRDS","spm":22,"status":false,"target":"_self","text":"分布式关系型数据库","workorderId":"1223"}],"text":"数据库"},{"products":[{"className":"icon-oss","href":"http://oss.console.aliyun.com/console/index","id":"oss","short":"OSS","spm":4,"status":true,"target":"_self","text":"开放存储服务","workorderId":"22"},{"className":"icon-cdn","href":"http://cdn.console.aliyun.com/","id":"cdn","short":"CDN","spm":5,"status":false,"target":"_self","text":"内容分发网络","workorderId":"92"},{"className":"icon-oas","href":"http://oas.console.aliyun.com/console/index","id":"oas","short":"OAS","spm":14,"status":false,"target":"_self","text":"开放归档服务","workorderId":"1211"},{"className":"icon-redisa","href":"https://kvstore.console.aliyun.com","id":"redisa","short":"KVStore","spm":23,"status":false,"target":"_self","text":"键值存储","workorderId":"1226"}],"text":"存储与CDN"},{"products":[{"className":"icon-odps","href":"http://odps.console.aliyun.com/console/index","id":"odps","short":"ODPS","spm":8,"status":false,"target":"_self","text":"开放数据处理服务","workorderId":"47"},{"className":"icon-dpc","href":"http://dpc.console.aliyun.com/index.htm","id":"dpc","short":"DPC","spm":20,"status":false,"target":"_self","text":"采云间","workorderId":""},{"className":"icon-ads","href":"http://ads.console.aliyun.com/","id":"ads","short":"ADS","spm":21,"status":false,"target":"_self","text":"分析数据库服务","workorderId":"1220"}],"text":"大规模计算"},{"products":[{"className":"icon-ace","href":"http://ace.console.aliyun.com","id":"ace","short":"ACE","spm":9,"status":true,"target":"_self","text":"云引擎","workorderId":"18"},{"className":"icon-sls","href":"http://sls.console.aliyun.com","id":"sls","short":"SLS","spm":12,"status":false,"target":"_self","text":"简单日志服务","workorderId":"1210"},{"className":"icon-mqs","href":"http://mqs.console.aliyun.com","id":"mqs","short":"MQS","spm":13,"status":false,"target":"_self","text":"消息队列服务","workorderId":"1212"},{"className":"icon-opensearch","href":"http://opensearch.console.aliyun.com","id":"opensearch","short":"","spm":15,"status":false,"target":"_self","text":"开放搜索服务","workorderId":"1213"},{"className":"icon-pts","href":"http://pts.aliyun.com/aliyun","id":"pts","short":"PTS","spm":16,"status":false,"target":"_self","text":"性能测试服务","workorderId":"1216"},{"className":"icon-ons","href":"http://ons.console.aliyun.com","id":"ons","short":"ONS","spm":19,"status":false,"target":"_self","text":"开放消息服务","workorderId":"1217"},{"className":"icon-edas","href":"http://edas.console.aliyun.com","id":"edas","short":"EDAS","spm":24,"status":false,"target":"_self","text":"企业级分布式应用服务","workorderId":"1239"}],"text":"应用服务"},{"products":[{"className":"icon-yundun","href":"http://yundun.console.aliyun.com/","id":"yundun","short":"","spm":10,"status":false,"target":"_self","text":"云盾","workorderId":"80"},{"className":"icon-yunjiankong","href":"http://console.aliyun.com/jiankong/","id":"jiankong","short":"","spm":11,"status":true,"target":"_self","text":"云监控","workorderId":"90"}],"text":"安全与管理"},{"products":[{"className":"icon-yuming","href":"http://netcn.console.aliyun.com/core/domain/list","id":"domain","short":"","spm":30,"status":true,"target":"_self","text":"域名","unit":"个","unopened":[{"href":"http://www.net.cn/domain/","iconName":"icon-detail","spm":"42","target":"_blank","text":"产品详情"}],"workorderId":"99"},{"className":"icon-yunjiexi","href":"http://netcn.console.aliyun.com/core/domain/tclist","id":"dns","short":"","spm":31,"status":true,"target":"_self","text":"云解析","unit":"个","unopened":[{"href":"http://www.net.cn/domain/dns/","iconName":"icon-detail","spm":"44","target":"_blank","text":"产品详情"}],"workorderId":""},{"className":"icon-yunxunizhuji","href":"http://netcn.console.aliyun.com/core/host/list2","id":"host","short":"","spm":32,"status":true,"target":"_self","text":"云虚拟主机","unit":"个","unopened":[{"href":"http://www.net.cn/hosting/virtualhost/","iconName":"icon-detail","spm":"46","target":"_blank","text":"产品详情"}],"workorderId":"98"},{"className":"icon-qiyeyouxiang","href":"http://netcn.console.aliyun.com/core/mail/list","id":"mail","short":"","spm":33,"status":true,"target":"_self","text":"企业邮箱","unit":"个","unopened":[{"href":"http://www.net.cn/mail/","iconName":"icon-detail","spm":"48","target":"_blank","text":"产品详情"}],"workorderId":"88"},{"className":"icon-wo-sitebuild","href":"http://netcn.console.aliyun.com/core/website/list","id":"website","short":"","spm":34,"status":false,"target":"_self","text":"标建网站","unit":"个","workorderId":"100"}],"text":"域名和网站"}],"locale":"zh-cn","messageInfo":{"messageList":[{"className":"问卷回访","formatCreatedTime":"2015-05-27","msgId":"12400138980","title":"“阿里绿网”用户调研活动"},{"className":"产品动态","formatCreatedTime":"2015-05-18","msgId":"12400134174","title":"“阿里绿网”产品正式上线通知"}],"total":2},"navLinks":{"entrances":[{"href":"https://ak-console.aliyun.com/","id":"accesskeys","target":"_blank","text":"AccessKeys"},{"id":"workorder","links":[{"href":"https://workorder.console.aliyun.com/#/ticket/list/","id":"workorderOwn","target":"_blank","text":"我的工单"},{"href":"https://workorder.console.aliyun.com/#/ticket/scene?productId=","hrefWithNoId":"https://workorder.console.aliyun.com/#/ticket/createIndex","id":"workorderAdd","target":"_blank","text":"提交工单"}],"text":"工单服务"},{"href":"http://beian.aliyun.com/","id":"beian","target":"_blank","text":"备案"},{"id":"help","links":[{"href":"http://www.aliyun.com/act/aliyun/console/faq.html","id":"faq","target":"_blank","text":"新版FAQ"},{"href":"http://help.aliyun.com","id":"help","target":"_blank","text":"帮助中心"},{"href":"http://docs.aliyun.com","id":"docs","target":"_blank","text":"文档中心"},{"href":"http://bbs.aliyun.com","id":"bbs","target":"_blank","text":"论坛"}],"text":"帮助"}],"homeLink":{"href":"http://home.console.aliyun.com","icon":"icon-home","target":"_self"},"logoLink":{"href":"http://www.aliyun.com","icon":"icon-logo2","target":"_blank"},"notificationLink":{"blankText":"您暂时没有公告消息","href":"https://msc.console.aliyun.com/#/innerMsg/unread/0","messageUrl":"https://msc.console.aliyun.com/#/innerMsg/allDetail/","text":"查看更多","title":"站内消息通知"},"productLink":{"text":"产品与服务"},"searchLink":{"href":"http://www.aliyun.com/s?k=","text":"全局搜索"},"userLink":{"links":[{"href":"http://www.net.cn/core/customer/index","target":"_self","text":"去万网用户中心"},{"href":"https://account.aliyun.com/logout/logout.htm?oauth_callback=","target":"_self","text":"退出"}]}},"productStatus":{"ace":true,"ads":false,"cdn":false,"dns":true,"domain":true,"dpc":false,"drds":false,"ecs":false,"edas":false,"ess":false,"host":true,"jiankong":true,"mail":true,"mqs":false,"oas":false,"ocs":false,"odps":false,"ons":false,"opensearch":false,"oss":true,"ots":false,"pts":false,"rds":true,"redisa":false,"slb":false,"sls":false,"vpc":false,"website":false,"yundun":false}});
      });
  }

  function updateMessageInfo(){
    $.ajax(TOPBAR_CONFIG.requestUrl.readMessage,{
      dataType:"jsonp"
    })
      .done(function(response){
        if(response && response.code == "200" && response.data){
          renderMessageInfo(topbarNode.find('.topbar-notice'),response.data,TOPBAR_CONFIG.defaultData.navLinks.notificationLink);
        }
      });
  }

})(window);
