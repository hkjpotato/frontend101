var USE_RTE=0;var Debug={write:function(text){if(jsDebug&&!Object.isUndefined(window.console)){console.log(text);}},dir:function(values){if(jsDebug&&!Object.isUndefined(window.console)&&!Prototype.Browser.IE&&!Prototype.Browser.Opera){console.dir(values);}},error:function(text){if(jsDebug&&!Object.isUndefined(window.console)){console.error(text);}},warn:function(text){if(jsDebug&&!Object.isUndefined(window.console)){console.warn(text);}},info:function(text){if(jsDebug&&!Object.isUndefined(window.console)){console.info(text);}}};Prototype.Browser.IE6=Prototype.Browser.IE&&parseInt(navigator.userAgent.substring(navigator.userAgent.indexOf("MSIE")+5))==6;Prototype.Browser.IE7=Prototype.Browser.IE&&parseInt(navigator.userAgent.substring(navigator.userAgent.indexOf("MSIE")+5))==7;Prototype.Browser.IE8=Prototype.Browser.IE&&parseInt(navigator.userAgent.substring(navigator.userAgent.indexOf("MSIE")+5))==8;Prototype.Browser.IE9=Prototype.Browser.IE&&parseInt(navigator.userAgent.substring(navigator.userAgent.indexOf("MSIE")+5))==9;Prototype.Browser.Chrome=Prototype.Browser.WebKit&&(navigator.userAgent.indexOf('Chrome/')>-1);if(!String.prototype.trim)
{String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g,'');};}
function isBody(element){return element.nodeName.toUpperCase()==='BODY';}
function isHtml(element){return element.nodeName.toUpperCase()==='HTML';}
function isDocument(element){return element.nodeType===Node.DOCUMENT_NODE;}
function isDetached(element){return element!==document.body&&!Element.descendantOf(element,document.body);}
Element.Methods.getOffsetParent=function(element){element=$(element);if(isDocument(element)||isDetached(element)||isBody(element)||isHtml(element))
return $(document.body);if(Prototype.Browser.IE){if(element.offsetParent&&element.offsetParent!=document.body&&Element.getStyle(element.offsetParent,'position')!='static')return $(element.offsetParent);if(element==document.body)return $(element);}else{var isInline=(Element.getStyle(element,'display')==='inline');if(!isInline&&element.offsetParent&&Element.getStyle(element.offsetParent,'position')!='static')return $(element.offsetParent);}
while((element=element.parentNode)&&element!==document.body){if(Element.getStyle(element,'position')!=='static'){return isHtml(element)?$(document.body):$(element);}}
return $(document.body);}
window.IPBoard=Class.create({namePops:[],topicPops:[],vars:[],lang:[],templates:[],editors:$A(),initDone:false,initialize:function()
{Debug.write("IPB js is loading...");document.observe("dom:loaded",function(){this.Cookie.init();Ajax.Responders.register({onLoading:function(handler){if(!Object.isUndefined(handler['options']['hideLoader'])&&handler['options']['hideLoader']!=false){return;}
if(!$('ajax_loading')){if(!ipb.templates['ajax_loading']){return;}
$('ipboard_body').insert(ipb.templates['ajax_loading']);}
var effect=new Effect.Appear($('ajax_loading'),{duration:0.2});},onComplete:function(){if(!$('ajax_loading')||!$('ajax_loading').visible()){return;}
var effect=new Effect.Fade($('ajax_loading'),{duration:0.2});if(!Object.isUndefined(ipb.hoverCard)){ipb.hoverCardRegister.postAjaxInit();}
$$("[data-clicklaunch]").invoke('clickLaunch');ipb.global.parseQuoteBoxes();ipb.global.removeLinkedLightbox();},onSuccess:function(){if(!Object.isUndefined(ipb.hoverCard)){ipb.hoverCardRegister.postAjaxInit();}},onFailure:function(t)
{if(!$('ajax_loading')||!$('ajax_loading').visible()){return;}
var effect=new Effect.Fade($('ajax_loading'),{duration:0.2});if(!Object.isUndefined(ipb.global))
{ipb.global.showInlineNotification(ipb.lang['ajax_failure']);}},onException:function(t,exception)
{if(!$('ajax_loading')||!$('ajax_loading').visible()){return;}
var effect=new Effect.Fade($('ajax_loading'),{duration:0.2});Debug.error(exception);if(!Object.isUndefined(ipb.global))
{}}});ipb.delegate.initialize();ipb.initDone=true;}.bind(this));},positionCenter:function(elem,dir)
{if(!$(elem)){return;}
elem_s=$(elem).getDimensions();window_s=document.viewport.getDimensions();window_offsets=document.viewport.getScrollOffsets();center={left:((window_s['width']-elem_s['width'])/2),top:((window_s['height']-elem_s['height'])/2)};if(typeof(dir)=='undefined'||(dir!='h'&&dir!='v'))
{$(elem).setStyle('top: '+center['top']+'px; left: '+center['left']+'px');}
else if(dir=='h')
{$(elem).setStyle('left: '+center['left']+'px');}
else if(dir=='v')
{$(elem).setStyle('top: '+center['top']+'px');}
$(elem).setStyle('position: fixed');},showModal:function()
{if(!$('ipb_modal'))
{this.createModal();}
this.modal.show();},hideModal:function()
{if(!$('ipb_modal')){return;}
this.modal.hide();},createModal:function()
{this.modal=new Element('div',{id:'ipb_modal'}).hide().addClassName('modal');this.modal.setStyle("width: 100%; height: 100%; position: fixed; top: 0px; left: 0px; overflow: hidden; z-index: 1000; opacity: 0.2");$('ipboard_body').insert({bottom:this.modal});},editorInsert:function(content,editorid)
{if(!editorid){var editor=ipb.textEditor.getEditor();}else{var editor=ipb.textEditor.getEditor(editorid);}
if(Object.isUndefined(editor))
{var editor=ipb.textEditor.getEditor();}
editor.insert(content);}});IPBoard.prototype.delegate={store:$A(),initialize:function()
{document.observe('click',function(e){if(Event.isLeftClick(e)||Prototype.Browser.IE||ipb.vars['is_touch'])
{var elem=null;var handler=null;var target=ipb.delegate.store.find(function(item){elem=e.findElement(item['selector']);if(elem){handler=item;return true;}else{return false;}});if(!Object.isUndefined(target))
{if(handler)
{Debug.write("Firing callback for selector "+handler['selector']);handler['callback'](e,elem,handler['params']);}}}});},register:function(selector,callback,params)
{ipb.delegate.store.push({selector:selector,callback:callback,params:params});}};IPBoard.prototype.Cookie={store:[],initDone:false,set:function(name,value,sticky)
{var expires='';var path='/';var domain='';if(!name)
{return;}
if(sticky)
{if(sticky==1)
{expires="; expires=Wed, 1 Jan 2020 00:00:00 GMT";}
else if(sticky==-1)
{expires="; expires=Thu, 01-Jan-1970 00:00:01 GMT";}
else if(sticky.length>10)
{expires="; expires="+sticky;}}
if(ipb.vars['cookie_domain'])
{domain="; domain="+ipb.vars['cookie_domain'];}
if(ipb.vars['cookie_path'])
{path=ipb.vars['cookie_path'];}
document.cookie=ipb.vars['cookie_id']+name+"="+escape(value)+"; path="+path+expires+domain+';';ipb.Cookie.store[name]=value;Debug.write("Set cookie: "+ipb.vars['cookie_id']+name+"="+value+"; path="+path+expires+domain+';');},get:function(name)
{if(ipb.Cookie.initDone!==true)
{ipb.Cookie.init();}
if(ipb.Cookie.store[name])
{return ipb.Cookie.store[name];}
return'';},doDelete:function(name)
{Debug.write("Deleting cookie "+name);ipb.Cookie.set(name,'',-1);},init:function()
{if(ipb.Cookie.initDone)
{return true;}
skip=['session_id','ipb_admin_session_id','member_id','pass_hash'];cookies=$H(document.cookie.replace(" ",'').toQueryParams(";"));if(cookies)
{cookies.each(function(cookie){cookie[0]=cookie[0].strip();if(ipb.vars['cookie_id']!='')
{if(!cookie[0].startsWith(ipb.vars['cookie_id']))
{return;}
else
{cookie[0]=cookie[0].replace(ipb.vars['cookie_id'],'');}}
if(skip[cookie[0]])
{return;}
else
{ipb.Cookie.store[cookie[0]]=unescape(cookie[1]||'');Debug.write("Loaded cookie: "+cookie[0]+" = "+cookie[1]);}});}
ipb.Cookie.initDone=true;}};IPBoard.prototype.validate={isFilled:function(elem)
{if(!$(elem)){return null;}
return!$F(elem).blank();},isNumeric:function(elem)
{if(!$(elem)){return null;}
return $F(elem).match(/^[\d]+?$/);},isMatching:function(elem1,elem2)
{if(!$(elem1)||!$(elem2)){return null;}
return $F(elem1)==$F(elem2);},email:function(elem)
{if(!$(elem)){return null;}
if($F(elem).match(/^.+@.+\..{2,4}$/)){return true;}else{return false;}}};IPBoard.prototype.Autocomplete=Class.create({initialize:function(id,options)
{this.id=$(id).id;this.timer=null;this.last_string='';this.internal_cache=$H();this.pointer=0;this.items=$A();this.observing=true;this.objHasFocus=null;this.options=Object.extend({min_chars:3,multibox:false,global_cache:false,goToUrl:false,classname:'ipb_autocomplete',templates:{wrap:new Template("<ul id='#{id}'></ul>"),item:new Template("<li id='#{id}' data-url='#{url}'>#{itemvalue}</li>")}},arguments[1]||{});if(!$(this.id)){Debug.error("Invalid textbox ID");return false;}
this.obj=$(this.id);if(!this.options.url)
{Debug.error("No URL specified for autocomplete");return false;}
$(this.obj).writeAttribute('autocomplete','off');this.buildList();$(this.obj).observe('focus',this.timerEventFocus.bindAsEventListener(this));$(this.obj).observe('blur',this.timerEventBlur.bindAsEventListener(this));$(this.obj).observe('keydown',this.eventKeypress.bindAsEventListener(this));},eventKeypress:function(e)
{if(![Event.KEY_TAB,Event.KEY_UP,Event.KEY_DOWN,Event.KEY_LEFT,Event.KEY_RIGHT,Event.KEY_RETURN].include(e.keyCode)){return;}
console.log(e.shiftKey);if(e.shiftKey===true){return;}
if($(this.list).visible())
{switch(e.keyCode)
{case Event.KEY_TAB:case Event.KEY_RETURN:this.selectCurrentItem(e);break;case Event.KEY_UP:case Event.KEY_LEFT:this.selectPreviousItem(e);break;case Event.KEY_DOWN:case Event.KEY_RIGHT:this.selectNextItem(e);break;}
Event.stop(e);}},selectCurrentItem:function(e)
{var current=$(this.list).down('.active');this.unselectAll();if(!Object.isUndefined(current))
{var itemid=$(current).id.replace(this.id+'_ac_item_','');if(!itemid){return;}
if(this.options.goToUrl&&$(current).readAttribute('data-url'))
{window.location=$(current).readAttribute('data-url');return false;}
var value=this.items[itemid].replace('&amp;','&').replace(/&#39;/g,"'").replace(/&gt;/g,'>').replace(/&lt;/g,'<').replace(/&#33;/g,'!');if(this.options.multibox)
{if($F(this.obj).indexOf(',')!==-1)
{var pieces=$F(this.obj).split(',');pieces[pieces.length-1]='';$(this.obj).value=pieces.join(',')+' ';}
else
{$(this.obj).value='';$(this.obj).focus();}
$(this.obj).value=$F(this.obj)+value+', ';}
else
{$(this.obj).value=value;var effect=new Effect.Fade($(this.list),{duration:0.3});}}
$(this.obj).focus();if(Prototype.Browser.IE)
{if($(this.obj).createTextRange)
{var r=$(this.obj).createTextRange();r.moveStart("character",$(this.obj).value.length);r.select();}}},selectThisItem:function(e)
{this.unselectAll();var items=$(this.list).immediateDescendants();var elem=Event.element(e);while(!items.include(elem))
{elem=elem.up();}
$(elem).addClassName('active');},selectPreviousItem:function(e)
{var current=$(this.list).down('.active');this.unselectAll();if(Object.isUndefined(current))
{this.selectFirstItem();}
else
{var prev=$(current).previous();if(prev){$(prev).addClassName('active');}
else
{this.selectLastItem();}}},selectNextItem:function(e)
{var current=$(this.list).down('.active');this.unselectAll();if(Object.isUndefined(current)){this.selectFirstItem();}
else
{var next=$(current).next();if(next){$(next).addClassName('active');}
else
{this.selectFirstItem();}}},selectFirstItem:function()
{if(!$(this.list).visible()){return;}
this.unselectAll();$(this.list).firstDescendant().addClassName('active');},selectLastItem:function()
{if(!$(this.list).visible()){return;}
this.unselectAll();var d=$(this.list).immediateDescendants();var l=d[d.length-1];if(l)
{$(l).addClassName('active');}},unselectAll:function()
{$(this.list).childElements().invoke('removeClassName','active');},timerEventBlur:function(e)
{window.clearTimeout(this.timer);this.eventBlur.bind(this).delay(0.6,e);},timerEventFocus:function(e)
{this.timer=this.eventFocus.bind(this).delay(0.4,e);},eventBlur:function(e)
{this.objHasFocus=false;if($(this.list).visible())
{var effect=new Effect.Fade($(this.list),{duration:0.3});}},eventFocus:function(e)
{if(!this.observing){Debug.write("Not observing keypress");return;}
this.objHasFocus=true;this.timer=this.eventFocus.bind(this).delay(0.6,e);var curValue=this.getCurrentName();if(curValue==this.last_string){return;}
if(curValue.length<this.options.min_chars){if($(this.list).visible())
{var effect=new Effect.Fade($(this.list),{duration:0.3,afterFinish:function(){$(this.list).update();}.bind(this)});}
return;}
this.last_string=curValue;json=this.cacheRead(curValue);if(json==false){var request=new Ajax.Request(this.options.url+encodeURIComponent(curValue),{method:'get',evalJSON:'force',onSuccess:function(t)
{if(Object.isUndefined(t.responseJSON))
{Debug.error("Invalid response returned from the server");return;}
if(t.responseJSON['error'])
{switch(t.responseJSON['error'])
{case'requestTooShort':Debug.warn("Server said request was too short, skipping...");break;default:Debug.error("Server returned an error: "+t.responseJSON['error']);break;}
return false;}
if(t.responseText!="[]")
{this.cacheWrite(curValue,t.responseJSON);this.updateAndShow(t.responseJSON);}}.bind(this)});}
else
{this.updateAndShow(json);}},updateAndShow:function(json)
{if(!json){return;}
this.updateList(json);if(!$(this.list).visible()&&this.objHasFocus)
{Debug.write("Showing");var effect=new Effect.Appear($(this.list),{duration:0.3,afterFinish:function(){this.selectFirstItem();}.bind(this)});}},cacheRead:function(value)
{if(this.options.global_cache!=false)
{if(!Object.isUndefined(this.options.global_cache.get(value))){Debug.write("Read from global cache");return this.options.global_cache.get(value);}}
else
{if(!Object.isUndefined(this.internal_cache.get(value))){Debug.write("Read from internal cache");return this.internal_cache.get(value);}}
return false;},cacheWrite:function(key,value)
{if(this.options.global_cache!==false){this.options.global_cache.set(key,value);}else{this.internal_cache.set(key,value);}
return true;},getCurrentName:function()
{if(this.options.multibox)
{if($F(this.obj).indexOf(',')===-1){return $F(this.obj).strip();}
else
{var pieces=$F(this.obj).split(',');var lastPiece=pieces[pieces.length-1];return lastPiece.strip();}}
else
{return $F(this.obj).strip();}},buildList:function()
{if($(this.id+'_ac'))
{return;}
var finalPos={};var sourcePos=$(this.id).viewportOffset();var sourceDim=$(this.id).getDimensions();var delta=[0,0];var parent=null;var screenScroll=document.viewport.getScrollOffsets();var ul=this.options.templates.wrap.evaluate({id:this.id+'_ac'});var test=$(this.id).up('.popupWrapper');if(!Object.isUndefined(test)&&test.getStyle('position')=='fixed')
{$(this.id).up().insert({bottom:ul});parent=$(this.id).getOffsetParent();delta=[parseInt(parent.getStyle('left')/2),parseInt(parent.getStyle('top')/2)];finalPos['left']=delta[0];finalPos['top']=delta[1]+screenScroll.top;$(this.id+'_ac').setStyle({'zIndex':10002});}
else
{$$('body')[0].insert({bottom:ul});if(Element.getStyle($(this.id),'position')=='absolute')
{parent=$(this.id).getOffsetParent();delta=[parseInt(parent.getStyle('left')),parseInt(parent.getStyle('top'))];}
finalPos['left']=sourcePos[0]-delta[0];finalPos['top']=sourcePos[1]-delta[1]+screenScroll.top;}
finalPos['top']=finalPos['top']+sourceDim.height;$(this.id+'_ac').setStyle('position: absolute; top: '+finalPos['top']+'px; left: '+finalPos['left']+'px;').hide();this.list=$(this.id+'_ac');},updateList:function(json)
{if(!json||!$(this.list)){return;}
var newitems='';this.items=$A();json=$H(json);json.each(function(item)
{var li=this.options.templates.item.evaluate({id:this.id+'_ac_item_'+item.key,itemid:item.key,itemvalue:item.value['showas']||item.value['name'],img:item.value['img']||'',img_w:item.value['img_w']||'',img_h:item.value['img_h']||'',url:item.value['url']||''});this.items[item.key]=item.value['name'];newitems=newitems+li;}.bind(this));$(this.list).update(newitems);$(this.list).immediateDescendants().each(function(elem){$(elem).observe('mouseover',this.selectThisItem.bindAsEventListener(this));$(elem).observe('click',this.selectCurrentItem.bindAsEventListener(this));$(elem).setStyle('cursor: pointer');}.bind(this));if($(this.list).visible())
{this.selectFirstItem();}}});getQueryStringParamByName=function(name)
{name=name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");var regexS="[\\?&]"+name+"=([^&#]*)";var regex=new RegExp(regexS);var results=regex.exec(window.location.search);if(results==null)
{return"";}
else
{return decodeURIComponent(results[1].replace(/\+/g," "));}};Object.extend(RegExp,{escape:function(text)
{if(!arguments.callee.sRE)
{var specials=['/','.','*','+','?','|','(',')','[',']','{','}','\\','$'];arguments.callee.sRE=new RegExp('(\\'+specials.join('|\\')+')','g');}
return text.replace(arguments.callee.sRE,'\\$1');}});String.prototype.regExpEscape=function()
{var text=this;return text.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,"\\$&");};String.prototype.escapeHtml=function()
{return this.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#039;");};String.prototype.unEscapeHtml=function()
{var _t=this.replace(/&amp;/g,"&");return _t.replace(/&lt;/g,"<").replace(/&gt;/g,">").replace(/&quot;/g,'"').replace(/&#039;/g,"'").replace(/&#39;/g,"'");};String.prototype.encodeUrl=function()
{var text=this;var regcheck=text.match(/[\x90-\xFF]/g);if(regcheck)
{for(var i=0;i<regcheck.length;i++)
{text=text.replace(regcheck[i],'%u00'+(regcheck[i].charCodeAt(0)&0xFF).toString(16).toUpperCase());}}
return escape(text).replace(/\+/g,"%2B").replace(/%20/g,'+').replace(/\*/g,'%2A').replace(/\//g,'%2F').replace(/@/g,'%40');};String.prototype.encodeParam=function()
{var text=this;var regcheck=text.match(/[\x90-\xFF]/g);if(regcheck)
{for(var i=0;i<regcheck.length;i++)
{text=text.replace(regcheck[i],'%u00'+(regcheck[i].charCodeAt(0)&0xFF).toString(16).toUpperCase());}}
return escape(text).replace(/\+/g,"%2B");};Date.prototype.getDateAndTime=function(unix)
{var a=new Date(parseInt(unix)*1000);var months=ipb.lang['gbl_months'].split(',');var year=a.getFullYear();var month=months[a.getMonth()];var date=a.getDate();var hour=a.getHours();var min=a.getMinutes();var sec=a.getSeconds();return{year:year,monthName:month,month:('0'+a.getMonth()+1).slice(-2),date:('0'+date).slice(-2),hour:('0'+hour).slice(-2),min:('0'+min).slice(-2),sec:('0'+sec).slice(-2),dst:a.getTimezoneOffset()};};Date.prototype.getDST=function()
{var beginning=new Date("January 1, 2008");var middle=new Date("July 1, 2008");var difference=middle.getTimezoneOffset()-beginning.getTimezoneOffset();var offset=this.getTimezoneOffset()-beginning.getTimezoneOffset();if(difference!=0)
{if(difference<0)
{return(difference==offset)?1:0;}
else
{return(difference!=offset)?1:0;}}
else
{return 0;}};var Loader={require:function(name)
{document.write("<script type='text/javascript' src='"+name+".js'></script>");},boot:function()
{$A(document.getElementsByTagName("script")).findAll(function(s)
{return(s.src&&s.src.match(/ipb\.js(\?.*)?$/));}).each(function(s){var path=s.src.replace(/ipb\.js(\?.*)?$/,'');var includes=s.src.match(/\?.*load=([a-zA-Z0-9_,\.]*)/);if(!Object.isUndefined(includes)&&includes!=null&&includes[1])
{includes[1].split(',').each(function(include)
{if(include)
{Loader.require(path+"ips."+include);}});}});}};var callback={afterOpen:function(popup){try{$('pj_'+$(elem).identify()+'_input').activate();}
catch(err){}}};Element.addMethods({getInnerText:function(element)
{element=$(element);return element.innerText&&!window.opera?element.innerText:element.innerHTML.stripScripts().unescapeHTML().replace(/[\n\r\s]+/g,' ');},defaultize:function(element,lang)
{if(ipb.global._supportsPlaceholder==null){ipb.global._supportsPlaceholder=(function(){var i=document.createElement('input');return'placeholder'in i;})();}
if(ipb.global._supportsPlaceholder){if($F(element)==lang||$F(element).empty()){$(element).removeClassName('inactive').writeAttribute('placeholder',lang).value='';}}else{if($F(element)==lang||$F(element).empty()){$(element).addClassName('inactive').value=lang;}
$(element).observe('focus',function(e){if($(element).hasClassName('inactive')&&($F(element)==''||$F(element)==lang)){$(element).removeClassName('inactive').value='';}else{$(element).removeClassName('inactive');}}).observe('blur',function(e){if($F(element).empty()){$(element).addClassName('inactive').value=lang;}});var form=$(element).up('form');if(!Object.isUndefined(form)){$(form).observe('submit',function(e){if($(element).hasClassName('inactive')){$(element).value='';}});}}},clickLaunch:function(element)
{var _callback=$(element).readAttribute("data-clicklaunch");var _scope='global';try{var _try=$(element).readAttribute("data-scope");_scope=(_try)?_try.replace("ipb.",''):_scope;}catch(e){};if($(element).retrieve('clickevent')){try{$(element).retrieve('clickevent').stop();}catch(err){};}
var click=$(element).on('click',function(e){Event.stop(e);ipb[_scope][_callback](element,e);});$(element).store('clickevent',click);},confirmAction:function(element,callback)
{var _text=$(element).readAttribute("data-confirmaction");var _ok='';if(callback)
{_ok=callback;}
else if(element.tagName=='FORM')
{_ok="$('"+element.id+"').submit()";}
else
{_ok='window.location=\''+element.readAttribute('href')+'\'';}
if(!_text||_text=='true')
{_text=ipb.lang['gbl_confirm_desc'];}
var _options={type:'pane',modal:true,initial:'<div><h3>'+ipb.lang['gbl_confirm_text']+'</h3><div class="ipsPad ipsForm_center"><p>'+_text+'</p><br /><span onclick="ipb.global.popups[\'conact\'].hide();" class="clickable ipsButton_secondary important">'+ipb.lang['gbl_confirm_cancel']+'</span> &nbsp; <span onclick="'+_ok+'" class="clickable ipsButton_secondary">'+ipb.lang['gbl_confirm_ok']+'</span></div>',hideAtStart:false,w:'300px',h:150};if(element.tagName=='FORM'||callback)
{if(!Object.isUndefined(ipb.global.popups['conact']))
{ipb.global.popups['conact'].kill();}
ipb.global.popups['conact']=new ipb.Popup('confirm',_options);}
else
{$(element).on('click',function(e)
{Event.stop(e);if(!Object.isUndefined(ipb.global.popups['conact']))
{ipb.global.popups['conact'].kill();}
ipb.global.popups['conact']=new ipb.Popup('confirm',_options);});}},tooltip:function(element,options){options=Object.extend({template:new Template("<div class='ipsTooltip' id='#{id}' style='display: none'><div class='ipsTooltip_inner'>#{content}</div></div>"),position:'auto',content:$(element).readAttribute("data-tooltip").stripTags().escapeHTML(),animate:true,overrideBrowser:true,delay:0.4},options);var show=function(e){if(options.delay&&!options._still_going){return;}
if(!options.content){return;}
var id=$(element).identify();if(!$(id+'_tooltip')){$(document.body).insert({'bottom':options.template.evaluate({'id':id+'_tooltip','content':options.content})});}
if(options.overrideBrowser&&$(element).hasAttribute('title')){$(element).writeAttribute("data-title",$(element).readAttribute('title').stripTags().escapeHTML()).writeAttribute("title",false);}
var tooltip=$(id+'_tooltip').setStyle({position:'absolute'});var layout=$(element).getLayout();var position=$(element).cumulativeOffset();var dims=$(id+'_tooltip').getDimensions();var docDim=$(document.body).getLayout();if(options.position=='auto'){if(position.left+(layout.get('padding-box-width')/2)-(dims.width/2)<0){options.position='right';}else if(position.left+(dims.width/2)>docDim.get('width')){options.position='left';}else{options.position='top';}}
Debug.write(dims);switch(options.position){case'top':$(tooltip).setStyle({top:(position.top-dims.height-1)+'px',left:(position.left+(layout.get('padding-box-width')/2)-(dims.width/2))+'px'}).addClassName('top');break;case'bottom':$(tooltip).setStyle({top:(position.top+layout.get('padding-box-height')+1)+'px',left:(position.left+(layout.get('padding-box-width')/2)-(dims.width/2))+'px'}).addClassName('bottom');break;case'left':$(tooltip).setStyle({top:(position.top-(layout.get('padding-box-height')/2))+'px',left:(position.left-dims.width-3)+'px'}).addClassName('left');break;case'right':$(tooltip).setStyle({top:(position.top-(layout.get('padding-box-height')/2))+'px',left:(position.left+layout.get('padding-box-width')-3)+'px'}).addClassName('right');break;}
if(options.animate){new Effect.Appear($(tooltip),{duration:0.3,queue:'end'});}else{$(tooltip).show();}},hide=function(e){var id=$(element).identify();if(!$(id+'_tooltip')){return;}
if(options.animate){new Effect.Fade($(id+'_tooltip'),{duration:0.2,queue:'end'});}else{$(id+'_tooltip').hide();}};$(element).observe("mouseenter",function(e){if(options.delay){options._still_going=true;show.delay(options.delay,e);}else{show(e);}}).observe("click",function(e){options._still_going=false;hide();}).observe("mouseleave",function(e)
{options._still_going=false;hide();});}});var _global=window.IPBoard;_global.prototype.global={searchTimer:[],searchLastQuery:'',rssItems:[],reputation:{},popups:{},ac_cache:$H(),pageJumps:$H(),pageJumpMenus:$H(),boardMarkers:$H(),searchResults:$H(),tidPopOpen:0,activeTab:'forums',userCards:null,inlineNotification:{timers:[]},_supportsPlaceholder:null,init:function()
{Debug.write("Initializing ips.global.js");document.observe("dom:loaded",function(){ipb.global.initEvents();});},initEvents:function()
{ipb.delegate.register(".warn_link",ipb.global.displayWarnLogs);ipb.delegate.register(".mini_friend_toggle",ipb.global.toggleFriend);ipb.delegate.register(".__topic_preview",ipb.global.topicPreview);ipb.delegate.register('.bbc_spoiler_show',ipb.global.toggleSpoiler);ipb.delegate.register('a[rel~="external"]',ipb.global.openNewWindow);ipb.delegate.register('._repLikeMore',ipb.global.repLikeMore);ipb.delegate.register('a[rel~="quickNavigation"]',ipb.global.openQuickNavigation);if($('sign_in')&&!$('sign_in').hasClassName('no_ajax')){$('sign_in').on('click',ipb.global.inlineSignin);}
if($('rss_feed')){ipb.global.buildRSSmenu();}
if(!Object.isUndefined(ipb.vars['notificationData']))
{new ipb.Popup('navigation_popup',{type:'modal',initial:ipb.templates['notificationTemplate'].evaluate(ipb.vars['notificationData']),hideAtStart:false,w:'600px',h:250});}
if($('backtotop')){$('backtotop').observe("click",function(e){Event.stop(e);window.scroll(0,0);});}
ipb.global.buildPageJumps();ipb.global.initUserCards();if(!Object.isUndefined(ipb.templates['inlineMsg'])&&ipb.templates['inlineMsg']!=''){ipb.global.showInlineNotification(ipb.templates['inlineMsg']);}
if($('search-box')){ipb.global.contextualSearch();}
if($('user_link')){new ipb.Menu($('user_link'),$('user_link_menucontent'));}
if($('new_skin')){new ipb.Menu($('new_skin'),$('new_skin_menucontent'));}
if($('new_language')){new ipb.Menu($('new_language'),$('new_language_menucontent'));}
if($('mark_all_read')){new ipb.Menu($('mark_all_read'),$('mark_all_read_menucontent'));}
$$("[data-tooltip]").invoke('tooltip');$$("[data-clicklaunch]").invoke('clickLaunch');$$("[data-confirmaction]").invoke('confirmAction');if($('statusUpdateGlobal')){$('statusUpdateGlobal').defaultize(ipb.lang['global_status_update']);$('statusSubmitGlobal').observe('click',ipb.global.statusUpdated);}
ipb.global.parseQuoteBoxes();ipb.global.removeLinkedLightbox();$$('a.resized_img').each(function(elem)
{if($(elem).previous('a.bbc_url'))
{var test=$(elem).previous('a.bbc_url');if(!test.innerHTML.length)
{$(elem).writeAttribute('href',test.href);$(elem).writeAttribute('rel',test.rel);test.remove();}}});if(!Object.isUndefined(ipb.hoverCard)&&ipb.vars['is_touch']===false)
{var ajaxUrl=ipb.vars['base_url']+"app=core&module=ajax&section=tags&do=getTagsAsPopUp&md5check="+ipb.vars['secure_hash'];ipb.hoverCardRegister.initialize('tagsPopUp',{'w':'500px','delay':750,'position':'auto','ajaxUrl':ajaxUrl,'getId':true,'setIdParam':'key'});}},parseQuoteBoxes:function()
{$$('blockquote.ipsBlockquote').each(function(el)
{if(!$(el).hasClassName('built'))
{var author='';var cid='';var time=0;var date='';var collapsed=0;var _extra='';var _a=new Element('span');try{author=$(el).getAttribute('data-author')?$(el).getAttribute('data-author').escapeHtml():'';cid=$(el).getAttribute('data-cid')?$(el).getAttribute('data-cid').escapeHtml():'';time=$(el).getAttribute('data-time')?$(el).getAttribute('data-time').escapeHtml():0;date=$(el).getAttribute('data-date')?$(el).getAttribute('data-date').escapeHtml():'';collapsed=$(el).getAttribute('data-collapsed')?$(el).getAttribute('data-collapsed').escapeHtml():0;}catch(aCold){}
if(time)
{if(time==parseInt(time)&&time.length==10)
{var _tz=new Date().getTimezoneOffset()*60;var _date=new Date().getDateAndTime(parseInt(time));if(_date['dst']*60!=_tz)
{_tz=_tz-_date['dst']*60;_date=new Date().getDateAndTime(parseInt(time)-parseInt(_tz));}
var _ampm='';if(ipb.vars['hour_format']=="12")
{if(_date['hour']>12)
{_date['hour']-=12;_ampm=' '+ipb.lang['date_pm'];}
else if(_date['hour']==12)
{_ampm=' '+ipb.lang['date_pm'];}
else if(_date['hour']==0)
{_date['hour']=12;_ampm=' '+ipb.lang['date_am'];}
else
{_ampm=' '+ipb.lang['date_am'];}}
date=_date['date']+' '+_date['monthName']+' '+_date['year']+' - '+_date['hour']+':'+_date['min']+_ampm;}}
if(author&&date)
{_extra=ipb.lang['quote__date_author'].replace(/#name#/,author).replace(/#date#/,date);}
else if(author)
{_extra=ipb.lang['quote__author'].replace(/#name#/,author);}
if(_extra.length==0)
{_extra=ipb.lang['quote_title'];}
if(cid&&parseInt(cid)==cid)
{_a=new Element('a',{'class':'snapback right',rel:'citation',href:ipb.vars['board_url']+'/index.php?app=forums&module=forums&section=findpost&pid='+cid});_a.update(new Element('img',{src:ipb.vars['img_url']+'/snapback.png'}));}
el.insert({before:new Element('p',{'class':'citation'}).update(_extra).insert(_a)});try
{el.down('cite').hide();}
catch(err){}
el.addClassName('built');if(collapsed)
{var wrapper=new Element('div',{'class':'_quote-wrapper'}).update(el.innerHTML);el.update(wrapper);el.down('div._quote-wrapper').hide();el.insert(new Element('p',{'class':'___x clickable'}).update(ipb.lang['quote_expand']));el.down('p.___x').on('click',function(e,elem)
{elem.up('blockquote').down('div._quote-wrapper').show();elem.hide();});}}});},removeLinkedLightbox:function()
{$$('a.bbc_url').each(function(el)
{if(_thislightbox=$(el).down('span[rel~=lightbox]'))
{var contents=$(el).innerHTML.replace('<span rel="lightbox">','');contents=contents.replace('</span>','');$(el).innerHTML=contents;}});},lightBoxIsOff:function()
{$$('span[rel*="lightbox"]').each(function(elem)
{if(!$(elem).down('a'))
{$(elem).down('img').on('click',function(e,el){window.open(el.src);});}});},saveSocialShareDefaults:function(elem,e)
{var services={};$$('._share_x_').each(function(elem){services[elem.id.replace(/share_x_/,'')]=(elem.checked)?1:0;});new Ajax.Request(ipb.vars['base_url']+"app=core&section=sharelinks&module=ajax&do=savePostPrefs&md5check="+ipb.vars['secure_hash'],{method:'post',evalJSON:'force',parameters:services,onSuccess:function(t)
{if(Object.isUndefined(t.responseJSON))
{alert(ipb.lang['action_failed']);return;}
if(!Object.isUndefined(t.responseJSON['error']))
{alert(t.responseJSON['error']);}
else
{}}});},
/*!! statusUpdated */
statusUpdated:function(e)
{Event.stop(e);if($('statusUpdateGlobal').value.length<2||$('statusUpdateGlobal').value==ipb.lang['prof_update_default'])
{return false;}
var su_Twitter=$('su_TwitterGlobal')&&$('su_TwitterGlobal').checked?1:0;var su_Facebook=$('su_FacebookGlobal')&&$('su_FacebookGlobal').checked?1:0;var skin_group=($('statusHook'))?'boards':'profile';new Ajax.Request(ipb.vars['base_url']+"app=members&section=status&module=ajax&do=new&md5check="+ipb.vars['secure_hash']+"&skin_group="+skin_group+"&return=json&smallSpace=1",{method:'post',evalJSON:'force',parameters:{content:$('statusUpdateGlobal').value.encodeParam(),su_Twitter:su_Twitter,su_Facebook:su_Facebook},onSuccess:function(t)
{if(Object.isUndefined(t.responseJSON))
{alert(ipb.lang['action_failed']);return;}
if(t.responseJSON['error'])
{alert(t.responseJSON['error']);}
else
{try{if($('status_wrapper'))
{var memberId=0;try
{memberId=$('status_wrapper').readAttribute('data-member');}
catch(err){}
if(!memberId||(memberId==ipb.vars['member_id']))
{$('status_wrapper').innerHTML=t.responseJSON['html']+$('status_wrapper').innerHTML;if(ipb.status.myLatest)
{if($('statusWrap-'+ipb.status.myLatest))
{$('statusWrap-'+ipb.status.myLatest).hide();}}}}
ipb.menus.closeAll(e,true);ipb.global.showInlineNotification(ipb.lang['status_updated']);$('statusUpdateGlobal').value='';$('statusUpdateGlobal').defaultize(ipb.lang['global_status_update']);}
catch(err)
{Debug.error('Logging error: '+err);}}}});},changeSkin:function(element,e)
{Debug.dir(element);var skinId=$(element).readAttribute('data-skinid');var url=ipb.vars['base_url']+'app=core&module=ajax&section=skin&do=change&skinId='+skinId+'&secure_key='+ipb.vars['secure_hash'];Debug.write(url);new Ajax.Request(url,{method:'get',onSuccess:function(t)
{if(t.responseJSON['status']=='ok')
{window.location=window.location;window.location.reload(true);}
else
{ipb.global.errorDialogue(ipb.lang['ajax_failure']);}}});Event.stop(e);return false;},getInboxList:function(element,e)
{if(Object.isUndefined(ipb.global.popups['inbox']))
{ipb.global.popups['inbox']=true;ipb.menus.closeAll(e);$(element).identify();$(element).addClassName('ipbmenu');$('ipboard_body').insert(ipb.templates['header_menu'].evaluate({id:'user_inbox_link_menucontent'}));$('user_inbox_link_menucontent').setStyle('width: 300px').update("<div class='ipsPad ipsForm_center'><img src='"+ipb.vars['loading_img']+"' /></div>");var _newMenu=new ipb.Menu($(element),$("user_inbox_link_menucontent"));_newMenu.doOpen();var url=ipb.vars['base_url']+'app=members&module=ajax&section=messenger&do=getInboxDropDown';Debug.write(url);new Ajax.Request(url,{method:'post',evalJSON:'force',hideLoader:true,parameters:{secure_key:ipb.vars['secure_hash']},onSuccess:function(t)
{if(t.responseJSON['error'])
{if(t.responseJSON['__board_offline__'])
{ipb.global.errorDialogue(ipb.lang['board_offline']);ipb.menus.closeAll(e);}}
else
{$('user_inbox_link_menucontent').update(t.responseJSON['html']);try
{$(element).down('.ipsHasNotifications').fade({afterFinish:function(){$(element).down('.ipsHasNotifications').show().addClassName('ipsHasNotifications_blank');}});}catch(acold){}}}});}
Event.stop(e);return false;},getNotificationsList:function(element,e)
{Event.stop(e);if(Object.isUndefined(ipb.global.popups['notification']))
{ipb.global.popups['notification']=true;ipb.menus.closeAll(e);$(element).identify();$(element).addClassName('ipbmenu');$('ipboard_body').insert(ipb.templates['header_menu'].evaluate({id:'user_notifications_link_menucontent'}));$('user_notifications_link_menucontent').setStyle('width: 300px').update("<div class='ipsPad ipsForm_center'><img src='"+ipb.vars['loading_img']+"' /></div>");var _newMenu=new ipb.Menu($(element),$("user_notifications_link_menucontent"));_newMenu.doOpen();var url=ipb.vars['base_url']+'app=core&module=ajax&section=notifications&do=getlatest';Debug.write(url);new Ajax.Request(url,{method:'post',evalJSON:'force',hideLoader:true,parameters:{secure_key:ipb.vars['secure_hash']},onSuccess:function(t)
{if(t.responseJSON['error'])
{if(t.responseJSON['__board_offline__'])
{ipb.global.errorDialogue(ipb.lang['board_offline']);ipb.menus.closeAll(e);}}
else
{$('user_notifications_link_menucontent').update(t.responseJSON['html']);try
{$(element).down('.ipsHasNotifications').fade({afterFinish:function(){$(element).down('.ipsHasNotifications').show().addClassName('ipsHasNotifications_blank');}});}catch(acold){}}}});}
return false;},openQuickNavigation:function(e)
{Event.stop(e);if(ipb.global.popups['quickNav']){ipb.global.popups['quickNav'].show();}else{var url=ipb.vars['base_url']+"app=core&module=ajax&section=navigation&secure_key="+ipb.vars['secure_hash']+"&inapp="+ipb.vars['active_app'];ipb.global.popups['quickNav']=new ipb.Popup('navigation_popup',{type:'modal',ajaxURL:url,hideAtStart:false,w:'600px',h:460});ipb.delegate.register('a[rel~="ipsQuickNav"]',ipb.global.quickNavTabClick);}
return false;},launchPhotoEditor:function(elem,e)
{Event.stop(e);if(!Object.isUndefined(ipb.global.popups['photoEditor']))
{ipb.global.popups['photoEditor'].kill();}
var url=ipb.vars['base_url']+"&app=members&module=ajax&section=photo&do=show&secure_key="+ipb.vars['secure_hash'];ipb.global.popups['photoEditor']=new ipb.Popup('photo_popup',{type:'pane',modal:true,ajaxURL:url,hideAtStart:false,evalJs:'force',w:'750px',h:500});return false;},quickNavTabClick:function(e,elem)
{Event.stop(e);app=elem.readAttribute('data-app');var url=ipb.vars['base_url']+"app=core&module=ajax&section=navigation&secure_key="+ipb.vars['secure_hash']+"&do=panel&inapp="+app;new Ajax.Request(url.replace(/&amp;/g,'&'),{method:'get',evalJSON:'force',hideLoader:true,onSuccess:function(t)
{$('ipsNav_content').update(t.responseText);$$('a[rel~="ipsQuickNav"]').each(function(link)
{link.up('li').removeClassName('active');var _app=link.readAttribute('data-app');if(_app==app)
{link.up('li').addClassName('active');}});}});return false;},ajaxPagination:function(element,url)
{new Ajax.Request(url.replace(/&amp;/g,'&'),{method:'get',evalJSON:'force',hideLoader:true,onSuccess:function(t)
{$(element).update(t.responseText);}});return false;},inlineSignin:function(e)
{if(ipb.vars['is_touch']){return;}
if(!$('inline_login_form'))
{return;}
Event.stop(e);if(ipb.global.loginRedirect)
{window.location=ipb.global.loginRedirect;return;}
new ipb.Popup('sign_in_popup',{type:'pane',initial:$('inline_login_form').show(),hideAtStart:false,hideClose:false,defer:false,modal:true,w:'600px'},{afterShow:function(pop){try{$('ips_username').focus();}catch(err){}}});},forumMarkRead:function(elem,e)
{Event.stop(e);var id=$(elem).readAttribute("data-fid");if(!id){return;}
var url=ipb.vars['base_url']+'&app=forums&module=ajax&secure_key='+ipb.vars['secure_hash']+'&section=markasread&forumid='+id;new Ajax.Request(url,{method:'get',evalJSON:'force',onSuccess:function(t)
{if(t.responseText=='no_forum'||t.responseText=='no_permission'){alert(ipb.lang['mark_read_forum']);return;}
$$('.__topic').each(function(topic)
{if($(topic).hasClassName('unread'))
{var tid=$(topic).readAttribute("data-tid");if(tid)
{ipb.global.topicRemoveUnreadElements(tid);}}});}});},topicMarkRead:function(elem,e)
{Event.stop(e);var id=$(elem).readAttribute("data-tid");if(!id){return;}
var row=$('trow_'+id);var url=ipb.vars['base_url']+'&app=forums&module=ajax&secure_key='+ipb.vars['secure_hash']+'&section=topics&do=markRead&tid='+id;new Ajax.Request(url,{method:'get',evalJSON:'force',onSuccess:function(t)
{if(t.responseText=='no_topic'||t.responseText=='no_permission'){alert(ipb.lang['mark_read_topic']);return;}
$(elem).remove();ipb.global.topicPreview(e,row.down('.__topic_preview'));ipb.global.topicRemoveUnreadElements(id);}});},topicRemoveUnreadElements:function(tid)
{$('trow_'+tid).removeClassName('unread').down('.col_f_icon').select('a img').invoke('remove');},topicPreview:function(e,elem)
{Event.stop(e);var toggle=$(elem).down(".expander");var row=$(elem).up(".__topic");var id=$(row).readAttribute("data-tid");if(!id){return;}
if($(row).readAttribute('loadingPreview')=='yes'){return;}
$(row).writeAttribute('loadingPreview','yes');if($("topic_preview_"+id))
{if($("topic_preview_wrap_"+id).visible())
{new Effect.BlindUp($("topic_preview_wrap_"+id),{duration:0.3,afterFinish:function(){$('topic_preview_'+id).hide();}});row.removeClassName('highlighted');$(toggle).addClassName('closed').removeClassName('loading').removeClassName('open').writeAttribute('title',ipb.lang['open_tpreview']);}
else
{$('topic_preview_'+id).show();new Effect.BlindDown($("topic_preview_wrap_"+id),{duration:0.3});row.addClassName('highlighted');$(toggle).addClassName('open').removeClassName('loading').removeClassName('closed').writeAttribute('title',ipb.lang['close_tpreview']);}
$(row).writeAttribute('loadingPreview','no');}
else
{var url=ipb.vars['base_url']+'&app=forums&module=ajax&secure_key='+ipb.vars['secure_hash']+'&section=topics&do=preview&tid='+id;if(ipb.global.searchResults[id]){url+='&pid='+ipb.global.searchResults[id]['pid']+'&searchTerm='+ipb.global.searchResults[id]['searchterm'];}
$(toggle).addClassName('loading').removeClassName('closed').removeClassName('open');new Ajax.Request(url,{method:'get',evalJSON:'force',onSuccess:function(t)
{if(t.responseText=='no_topic'||t.responseText=='no_permission'){alert(ipb.lang['no_permission_preview']);$(toggle).addClassName('open').removeClassName('loading').removeClassName('closed').writeAttribute('title',ipb.lang['close_tpreview']);$(row).writeAttribute('loadingPreview','no');return;}
if(row.tagName=="TR")
{var count=row.childElements().size();var newrow=new Element('tr',{'class':'preview','id':'topic_preview_'+id});var newcell=new Element('td',{'colspan':count});var wrap=new Element('div',{'id':'topic_preview_wrap_'+id}).hide().update(new Element('div'));row.insert({after:newrow.insert(newcell.insert(wrap))});}
else
{var wrap=new Element('div',{'id':'topic_preview_wrap_'+id}).hide().update(new Element('div'));row.insert({after:wrap});}
wrap.update(t.responseText).relativize();new Effect.BlindDown(wrap,{duration:0.3});row.addClassName('highlighted');$(toggle).addClassName('open').removeClassName('loading').removeClassName('closed').writeAttribute('title',ipb.lang['close_tpreview']);$(row).writeAttribute('loadingPreview','no');}});}},activateMainMenu:function()
{if($("nav_other_apps")&&$("community_app_menu")){var start=totalW=$("nav_other_apps").getWidth()+20;var menuWidth=$("community_app_menu").getWidth();$("community_app_menu").select("li.skip_moremenu").each(function(elem){totalW+=$(elem).measure('margin-box-width');});$("community_app_menu").select("li:not(#nav_other_apps,.submenu_li)").each(function(elem){if($(elem).hasClassName('skip_moremenu'))
{return;}
totalW+=$(elem).measure('margin-box-width');if(totalW>=menuWidth)
{if(!$("more_apps_menucontent")){$$("body")[0].insert("<div id='more_apps_menucontent' class='submenu_container clearfix boxShadow'><div class='left'><ul class='submenu_links' id='more_apps_menucontentul'></ul></div></div>");}
$(elem).addClassName('submenu_li').removeClassName('left');$("more_apps_menucontentul").insert(elem);}});if($("more_apps_menucontent"))
{$("nav_other_apps").show();new ipb.Menu($('more_apps'),$('more_apps_menucontent'));}
Debug.write(menuWidth);}},initUserCards:function()
{if(!Object.isUndefined(ipb.hoverCard)&&ipb.vars['is_touch']===false&&ipb.vars['member_group']['g_mem_info']==1)
{var ajaxUrl=ipb.vars['base_url']+'&app=members&module=ajax&secure_key='+ipb.vars['secure_hash']+'&section=card';if(ipb.topic!==undefined&&ipb.topic.forum_id!==undefined)
{ajaxUrl+="&f="+ipb.topic.forum_id;}
ipb.hoverCardRegister.initialize('member',{'w':'500px','delay':750,'position':'auto','ajaxUrl':ajaxUrl,'getId':true,'setIdParam':'mid'});}},showInlineNotification:function(content,options)
{options=(Object.isUndefined(options))?{}:options;options.showClose=(Object.isUndefined(options.manualClose))?false:options.showClose;options.neverClose=(Object.isUndefined(options.neverClose))?false:options.neverClose;options.displayForSeconds=(Object.isUndefined(options.displayForSeconds))?5:options.displayForSeconds;if($('ipsGlobalNotification'))
{ipb.global.closeInlineNotification(function(){ipb.global.showInlineNotification(content,options);});return;}
else
{if($('ipbwrapper'))
{$('ipbwrapper').insert(new Element('div',{id:'ipsGlobalNotification'}).update(ipb.templates['global_notify'].evaluate({'message':content})));}
else
{$('ipboard_body').insert(new Element('div',{id:'ipsGlobalNotification'}).update(ipb.templates['global_notify'].evaluate({'message':content,'close':ipb.templates['global_notify_close']})));}
new Effect.Appear('ipsGlobalNotification',{duration:1.5});if(options.showClose)
{$('ipsGlobalNotification').insert(new Element('div',{id:'ipsGlobalNotification_close'}));$('ipsGlobalNotification_close').observe('click',ipb.global.closeInlineNotification);}
else if($('ipsGlobalNotification_close'))
{$('ipsGlobalNotification_close').observe('click',ipb.global.closeInlineNotification);}}
$('ipsGlobalNotification').on('click','span a',ipb.global.closeInlineNotification);if(options.neverClose!==true)
{try{clearTimeout(ipb.global.inlineNotification['timers']['close']);}
catch(e){}
ipb.global.inlineNotification['timers']['close']=setTimeout(ipb.global.closeInlineNotification,options.displayForSeconds*1000);}},closeInlineNotification:function(callback)
{callback=callback||Prototype.emptyFunction;if($('ipsGlobalNotification_close')){$('ipsGlobalNotification_close').stopObserving('click');}
try{clearTimeout(ipb.global.inlineNotification['timers']['close']);}
catch(e){}
new Effect.Fade('ipsGlobalNotification',{duration:1.0,afterFinish:function(){$('ipsGlobalNotification').remove();callback();}});},errorDialogue:function(text)
{errContent="<h3>"+ipb.lang['error_occured']+"</h3><div class='row2 ipsPad ipsForm_center'><p>"+text+"</p></div>";new ipb.Popup('generic__errorDialogue',{type:'pane',initial:errContent,stem:true,hideAtStart:false,hideClose:false,defer:false,warning:false,w:400});},okDialogue:function(text)
{okContent="<h3>"+ipb.lang['success']+"</h3><div class='row2 ipsPad ipsForm_center'><p>"+text+"</p></div>";new ipb.Popup('generic__okDialogue',{type:'pane',initial:okContent,stem:true,hideAtStart:false,hideClose:false,defer:false,w:400});},contextualSearch:function()
{if(!$('search_options')&&!$('search_options_menucontent')){return;}
if(!$('main_search'))
{return;}
$('main_search').defaultize(ipb.lang['search_default_value']);$('search').select('.submit_input').find(function(elem){$(elem).value='';});var update=function(noSelect)
{var checked=$('search_options_menucontent').select('input').find(function(elem){return $(elem).checked;});if(Object.isUndefined(checked)){checked=$('search_options_menucontent').select('input:first')[0];if(!checked){return;}
checked.checked=true;}
$('search_options').show().update($(checked).up('label').readAttribute('title')||'');if(noSelect!=true){$('main_search').focus();}
return true;};update(true);$('search_options_menucontent').select('input').invoke('observe','click',update);},fetchTid:function(e)
{var elem=Event.element(e);elem.identify();if(!elem.hasClassName('__topic'))
{elem=elem.up('.__topic');}
var id=elem.id;if(!id||!$(id))
{return 0;}
var m=$(id).className.match('__tid([0-9]+)');var tid=m[1];return tid;},displayWarnLogs:function(e,elem)
{mid=elem.id.match('warn_link_([0-9a-z]+)_([0-9]+)')[2];if(Object.isUndefined(mid)){return;}
if(parseInt(mid)==0){return false;}
Event.stop(e);var _url=ipb.vars['base_url']+'&app=core&module=ajax&secure_key='+ipb.vars['secure_hash']+'&section=warn&do=view&mid='+mid;warnLogs=new ipb.Popup('warnLogs',{type:'pane',modal:false,w:'500px',h:500,ajaxURL:_url,hideAtStart:false,close:'.cancel'});},toggleFriend:function(e,elem)
{Event.stop(e);var id=$(elem).id.match('friend_(.*)_([0-9]+)');if(Object.isUndefined(id[2])){return;}
var isFriend=($(elem).hasClassName('is_friend'))?1:0;var urlBit=(isFriend)?'remove':'add';var url=ipb.vars['base_url']+"app=members&section=friends&module=ajax&do="+urlBit+"&member_id="+id[2]+"&md5check="+ipb.vars['secure_hash'];new Ajax.Request(url,{method:'get',onSuccess:function(t)
{switch(t.responseText)
{case'pp_friend_timeflood':alert(ipb.lang['cannot_readd_friend']);Event.stop(e);break;case"pp_friend_already":alert(ipb.lang['friend_already']);Event.stop(e);break;case"error":return true;break;default:var newIcon=(isFriend)?ipb.templates['m_add_friend'].evaluate({id:id[2]}):ipb.templates['m_rem_friend'].evaluate({id:id[2]});var friends=$$('.mini_friend_toggle').each(function(fr){if($(fr).id.endsWith('_'+id[2]))
{if(isFriend){$(fr).removeClassName('is_friend').addClassName('is_not_friend').update(newIcon);}else{$(fr).removeClassName('is_not_friend').addClassName('is_friend').update(newIcon);}}});new Effect.Highlight($(elem),{startcolor:ipb.vars['highlight_color']});document.fire('ipb:friendRemoved',{friendID:id[2]});Event.stop(e);break;}}});},toggleFlagSpammer:function(memberId,flagStatus)
{if(flagStatus==true)
{if(confirm(ipb.lang['set_as_spammer']))
{var tid=0;var fid=0;var sid=0;if(typeof(ipb.topic)!='undefined')
{tid=ipb.topic.topic_id;fid=ipb.topic.forum_id;sid=ipb.topic.start_id;}
window.location=ipb.vars['base_url']+'app=core&module=modcp&do=setAsSpammer&member_id='+memberId+'&t='+tid+'&f='+fid+'&st='+sid+'&auth_key='+ipb.vars['secure_hash'];return false;}
else
{return false;}}
else
{alert(ipb.lang['is_spammer']);return false;}},toggleSpoiler:function(e,button)
{Event.stop(e);var returnvalue=$(button).up('.bbc_spoiler').down('.bbc_spoiler_wrapper').down('.bbc_spoiler_content').toggle();if(returnvalue.visible()){$(button).value=ipb.lang['spoiler_hide'];}else{$(button).value=ipb.lang['spoiler_show'];}},buildRSSmenu:function()
{$$('link').each(function(link)
{if(link.readAttribute('type')=="application/rss+xml")
{ipb.global.rssItems.push(ipb.templates['rss_item'].evaluate({url:link.readAttribute('href'),title:link.readAttribute('title').escapeHtml()}));}});if(ipb.global.rssItems.length>0)
{rssmenu=ipb.templates['rss_shell'].evaluate({items:ipb.global.rssItems.join("\n")});$('rss_feed').insert({after:rssmenu});new ipb.Menu($('rss_feed'),$('rss_menu'));}
else
{$('rss_feed').hide();}},repPopUp:function(e,repId,repApp,repType)
{if(ipb.global.popups['rep_'+repId]){ipb.global.popups['rep_'+repId].kill();}
var _url=ipb.vars['base_url']+'&app=core&module=ajax&secure_key='+ipb.vars['secure_hash']+'&section=reputation&do=view&repApp='+repApp+'&repType='+repType+'&repId='+repId;ipb.global.popups['rep_'+repId]=new ipb.Popup('rep_'+repId,{type:'balloon',stem:true,attach:{target:e,position:'auto'},hideAtStart:false,ajaxURL:_url,w:'300px',h:400});},closePMpopup:function(e)
{if($('pm_notification'))
{new Effect.Parallel([new Effect.Fade($('pm_notification')),new Effect.BlindUp($('pm_notification'))],{duration:0.5});}
Event.stop(e);},markReadPMpopup:function(e)
{if($('pm_notification'))
{var elem=Event.findElement(e,'a');var href=elem.href.replace(/&amp;/g,'&')+'&ajax=1';new Ajax.Request(href+"&md5check="+ipb.vars['secure_hash'],{method:'get',evalJSON:'force',onSuccess:function(t){}});new Effect.Parallel([new Effect.Fade($('pm_notification')),new Effect.BlindUp($('pm_notification'))],{duration:0.5});}
Event.stop(e);return false;},initGD:function()
{$('gd-antispam').observe('click',ipb.global.generateNewImage);if($('gd-image-link'))
{$('gd-image-link').observe('click',ipb.global.generateNewImage);}},generateImageExternally:function(elem)
{if(!$(elem)){return;}
$(elem).observe('click',ipb.global.generateNewImage);},generateNewImage:function(e)
{img=$('gd-antispam');Event.stop(e);oldSrc=img.src.toQueryParams();oldSrc=$H(oldSrc).toObject();if(!oldSrc['captcha_unique_id']){Debug.error("No captcha ID found");}
new Ajax.Request(ipb.vars['base_url']+"app=core&module=global&section=captcha&do=refresh&captcha_unique_id="+oldSrc['captcha_unique_id']+'&secure_key='+ipb.vars['secure_hash'],{method:'get',onSuccess:function(t)
{oldSrc['captcha_unique_id']=t.responseText;img.writeAttribute({src:ipb.vars['base_url']+$H(oldSrc).toQueryString()});$('regid').value=t.responseText;}});},registerReputation:function(id,url,rating)
{if(!$(id)){return;}
var rep_up=$(id).down('.rep_up');var rep_down=$(id).down('.rep_down');var domLikeStripId=($(url.domLikeStripId))?$(url.domLikeStripId):false;var sendUrl=ipb.vars['base_url']+'&app=core&module=ajax&section=reputation&do=add_rating&app_rate='+url.app+'&type='+url.type+'&type_id='+url.typeid+'&secure_key='+ipb.vars['secure_hash'];if($(rep_up)){$(rep_up).observe('click',ipb.global.repRate.bindAsEventListener(this,1,id));}
if($(rep_down)){$(rep_down).observe('click',ipb.global.repRate.bindAsEventListener(this,-1,id));}
ipb.global.reputation[id]={obj:$(id),domLikeStripId:domLikeStripId,url:url,sendUrl:sendUrl,currentRating:rating||0};Debug.write("Registered reputation");},repRate:function(e)
{Event.stop(e);var type=$A(arguments)[1];var id=$A(arguments)[2];var value=(type==1)?1:-1;if(!ipb.global.reputation[id]){return;}else{var rep=ipb.global.reputation[id];}
Debug.write(rep.sendUrl+'&rating='+value);new Ajax.Request(rep.sendUrl+'&rating='+value,{method:'get',onSuccess:function(t)
{if(t.responseJSON['status']=='ok')
{try{rep.obj.down('.rep_up').up('li').hide();rep.obj.down('.rep_down').up('li').hide();if(t.responseJSON['canRepUp']===true)
{rep.obj.down('.rep_up').up('li').show();}
if(t.responseJSON['canRepDown']===true)
{rep.obj.down('.rep_down').up('li').show();}}catch(err){Debug.error(err);}
var rep_display=rep.obj.down('.rep_show');if(rep_display)
{['positive','negative','zero'].each(function(c){rep_display.removeClassName(c);});var newValue=parseInt(t.responseJSON['rating']);if(newValue>0)
{rep_display.addClassName('positive');}
else if(newValue<0)
{rep_display.addClassName('negative');}
else
{rep_display.addClassName('zero');}
rep_display.update(newValue);}
if($(rep.domLikeStripId.id))
{if(t.responseJSON['likeData'].formatted!==false)
{$(rep.domLikeStripId.id).update(t.responseJSON['likeData'].formatted).show();}
else
{$(rep.domLikeStripId.id).update('').hide();}}}
else
{if(t.responseJSON['error']=='nopermission'||t.responseJSON['error']=='no_permission')
{ipb.global.errorDialogue(ipb.lang['no_permission']);}
else
{ipb.global.errorDialogue(t.responseJSON['error']);}}}});},repLikeMore:function(e,elem)
{Event.stop(e);try
{var id=elem.readAttribute('data-id');var app=elem.readAttribute('data-app');var type=elem.readAttribute('data-type');}
catch(e)
{Debug.error(e);}
if(!Object.isUndefined(ipb.global.popups['likeMore']))
{ipb.global.popups['likeMore'].kill();}
var popid='setfave_'+id;var _url=ipb.vars['base_url']+'&app=core&module=ajax&section=reputation&do=more&secure_key='+ipb.vars['secure_hash']+'&f_app='+app+'&f_type='+type+'&f_id='+id;Debug.write(_url);ipb.global.popups['likeMore']=new ipb.Popup(popid,{type:'pane',ajaxURL:_url,stem:false,hideAtStart:false,h:500,w:'450px'});},convertSize:function(size)
{var kb=1024;var mb=1024*1024;var gb=1024*1024*1024;if(size<kb){return size+" B";}
if(size<mb){return(size/kb).toFixed(2)+" KB";}
if(size<gb){return(size/mb).toFixed(2)+" MB";}
return(size/gb).toFixed(2)+" GB";},registerPageJump:function(source,options)
{if(!source||!options){return;}
ipb.global.pageJumps[source]=options;},buildPageJumps:function()
{$$('.pagejump').each(function(elem){var classes=$(elem).className.match(/pj([0-9]+)/);if(Object.isUndefined(classes)||!classes||!classes[1]){return;}
$(elem).identify();var temp=ipb.templates['page_jump'].evaluate({id:'pj_'+$(elem).identify()});$$('body')[0].insert(temp);$('pj_'+$(elem).identify()+'_submit').observe('click',ipb.global.pageJump.bindAsEventListener(this,$(elem).identify()));$('pj_'+$(elem).identify()+'_input').observe('keypress',function(e){if(e.which==Event.KEY_RETURN)
{ipb.global.pageJump(e,$(elem).identify());}});var wrap=$('pj_'+$(elem).identify()+'_wrap').addClassName('pj'+classes[1]).writeAttribute('jumpid',classes[1]);var callback={afterOpen:function(popup){try{$('pj_'+$(elem).identify()+'_input').activate();}
catch(err){}}};ipb.global.pageJumpMenus[classes[1]]=new ipb.Menu($(elem),$(wrap),{stopClose:true},callback);});},pageJump:function(e,elem)
{if(!$(elem)||!$('pj_'+$(elem).id+'_input')){return;}
var value=$F('pj_'+$(elem).id+'_input');var jumpid=$('pj_'+$(elem).id+'_wrap').readAttribute('jumpid');if(value.blank()){try{ipb.global.pageJumpMenus[source].doClose();}catch(err){}}
else
{value=parseInt(value);}
var options=ipb.global.pageJumps[jumpid];if(!options){Debug.dir(ipb.global.pageJumps);Debug.write(jumpid);return;}
var pageNum=((value-1)*options.perPage);Debug.write(pageNum);if(pageNum<1){pageNum=0;}
var separator=options.url.indexOf('&')!==-1?'&':'?';var url=options.url+separator+options.stKey+'='+pageNum;if(options.anchor)
{url=url+options.anchor;}
url=url.replace(/&amp;/g,'&');url=url.replace(/(http:|https:)?\/\//g,function($0,$1){return $1?$0:'/';});document.location=url;return;},openNewWindow:function(e,link,force)
{var ourHost=document.location.host;var newHost=link.host;if(Prototype.Browser.IE)
{newHost=newHost.replace(/^(.+?):(\d+)$/,'$1');}
if(ourHost!=newHost||force)
{window.open(link.href);Event.stop(e);return false;}
else
{return true;}},registerMarker:function(id,key,url)
{if(!$(id)||key.blank()||url.blank()){return;}
Debug.write("Marker INIT: "+id);$(id).observe('click',ipb.global.sendMarker.bindAsEventListener(this,id,key,url));},sendMarker:function(e,id,key,url)
{Event.stop(e);new Ajax.Request(url+"&secure_key="+ipb.vars['secure_hash'],{method:'get',evalJSON:'force',onSuccess:function(t)
{if(Object.isUndefined(t.responseJSON))
{Debug.error("Invalid server response");return false;}
if(t.responseJSON['error'])
{Debug.error(t.responseJSON['error']);return false;}
if($(id+'_tooltip')){$(id+'_tooltip').hide();}
$(id).up('tr').removeClassName('unread');$(id).replace(unreadIcon);var _intId=id.replace(/forum_img_/,'');if($("subforums_"+_intId))
{$$("#subforums_"+_intId+" li").each(function(elem){$(elem).removeClassName('unread');});}}});},registerCheckAll:function(id,classname)
{if(!$(id)){return;}
$(id).observe('click',ipb.global.checkAll.bindAsEventListener(this,classname));$$('.'+classname).each(function(elem){$(elem).observe('click',ipb.global.checkOne.bindAsEventListener(this,id));});},checkAll:function(e,classname)
{Debug.write('checkAll');var elem=Event.element(e);var checkboxes=$$('.'+classname);if(elem.checked){checkboxes.each(function(check){check.checked=true;});}else{checkboxes.each(function(check){check.checked=false;});}},checkOne:function(e,id)
{var elem=Event.element(e);if($(id).checked&&elem.checked==false)
{$(id).checked=false;}},updateReportStatus:function(e,reportID,noauto,noimg)
{Event.stop(e);var url=ipb.vars['base_url']+"app=core&amp;module=ajax&amp;section=reports&amp;do=change_status&secure_key="+ipb.vars['secure_hash']+"&amp;status=3&amp;id="+parseInt(reportID)+"&amp;noimg="+parseInt(noimg)+"&amp;noauto="+parseInt(noauto);new Ajax.Request(url.replace(/&amp;/g,'&'),{method:'post',evalJSON:'force',onSuccess:function(t)
{if(Object.isUndefined(t.responseJSON))
{alert(ipb.lang['action_failed']);return;}
try{$('rstat-'+reportID).update(t.responseJSON['img']);ipb.menus.closeAll(e);}catch(err){Debug.error(err);}}});},getTotalOffset:function(elem,top,left)
{if($(elem).getOffsetParent()!=document.body)
{Debug.write("Checking "+$(elem).id);var extra=$(elem).positionedOffset();top+=extra['top'];left+=extra['left'];return ipb.global.getTotalOffset($(elem).getOffsetParent(),top,left);}
else
{Debug.write("OK Finished!");return{top:top,left:left};}},checkPermission:function(text)
{if(text=="nopermission"||text=='no_permission')
{alert(ipb.lang['no_permission']);return false;}
return true;},checkForEnter:function(e,callback)
{if(![Event.KEY_RETURN].include(e.keyCode)){return;}
if(callback)
{switch(e.keyCode)
{case Event.KEY_RETURN:callback(e);break;}
Event.stop(e);}},checkDST:function()
{var memberHasDst=ipb.vars['dst_in_use'];var dstInEffect=new Date().getDST();if(memberHasDst-dstInEffect!=0)
{var url=ipb.vars['base_url']+'app=members&module=ajax&section=dst&md5check='+ipb.vars['secure_hash'];new Ajax.Request(url,{method:'get',onSuccess:function(t)
{return true;}});}}};var _menu=window.IPBoard;_menu.prototype.menus={registered:$H(),closeCallBack:false,init:function()
{Debug.write("Initializing ips.menu.js");document.observe("dom:loaded",function(){ipb.menus.initEvents();});},initEvents:function()
{Event.observe(document,'click',ipb.menus.docCloseAll);$$('.ipbmenu').each(function(menu){id=menu.identify();if($(id+"_menucontent"))
{new ipb.Menu(menu,$(id+"_menucontent"));}});},register:function(source,obj)
{ipb.menus.registered.set(source,obj);},registerCloseCallBack:function(callBack)
{ipb.menus.closeCallBack=callBack;},docCloseAll:function(e)
{ipb.menus.closeAll(e);},
/*!! Close all menus (forceClose ignores clicked in menu area check) */
closeAll:function(except,forceClose)
{ipb.menus.registered.each(function(menu,force){if(typeof(except)=='undefined'||(except&&menu.key!=except))
{try{if(forceClose||(!(except.target&&$(except.target).descendantOf(menu.value.target))&&except!=menu.key)){menu.value.doClose();}}catch(err){}}});if(Object.isFunction(ipb.menus.closeCallBack))
{ipb.menus.closeCallBack();}}};_menu.prototype.Menu=Class.create({initialize:function(source,target,options,callbacks){if(!$(source)||!$(target)){return;}
if(!$(source).id){$(source).identify();}
this.id=$(source).id+'_menu';this.source=$(source);this.target=$(target);this.callbacks=callbacks||{};this.options=Object.extend({eventType:'click',closeOnMouseout:false,stopClose:true,offsetX:0,offsetY:0},arguments[2]||{});$(source).observe('click',this.eventClick.bindAsEventListener(this));$(source).observe('mouseover',this.eventOver.bindAsEventListener(this));$(target).observe('click',this.targetClick.bindAsEventListener(this));if(this.options['closeOnMouseout']!==false)
{$(this.options['closeOnMouseout']).observe('mouseleave',this.mouseOutClose.bindAsEventListener(this));}
if($($(source).id+'_alt'))
{$($(source).id+'_alt').observe('click',this.eventClick.bindAsEventListener(this,$($(source).id+'_alt')));$($(source).id+'_alt').observe('mouseover',this.eventOver.bindAsEventListener(this));}
$(this.target).setStyle('position: absolute;').hide().setStyle({zIndex:9999});$(this.target).descendants().each(function(elem){$(elem).setStyle({zIndex:10000});});ipb.menus.register($(source).id,this);if(Object.isFunction(this.callbacks['afterInit']))
{this.callbacks['afterInit'](this);}},doOpen:function(elem)
{Debug.write("Menu open");var pos={};var _source=(this.options.positionSource)?this.options.positionSource:this.source;if(!Object.isUndefined(elem))
{var _source=elem;}
var sourcePos=$(_source).positionedOffset();var _sourcePos=$(_source).cumulativeOffset();var _offset=$(_source).cumulativeScrollOffset();var realSourcePos={top:_sourcePos.top-_offset.top,left:_sourcePos.left-_offset.left};var sourceDim=$(_source).getDimensions();var screenDim=document.viewport.getDimensions();var menuDim={width:$(this.target).measure('border-box-width'),height:$(this.target).measure('border-box-height')};var isFixed=$(_source).ancestors().find(function(el){return el.getStyle('position')=='fixed';});if(isRTL)
{if(sourcePos.top<0)
{sourcePos.top=realSourcePos.top;}
if($(_source).id=='user_link')
{sourcePos.left=sourcePos.left-(parseInt($(_source).getStyle('padding-left').replace(/px/,''))+parseInt($(_source).getStyle('margin-left').replace(/px/,'')));}}
Debug.write("realSourcePos: "+realSourcePos.top+" x "+realSourcePos.left);Debug.write("sourcePos: "+sourcePos.top+" x "+sourcePos.left);Debug.write("scrollOffset: "+_offset.top+" x "+_offset.left);Debug.write("_sourcePos: "+_sourcePos.top+" x "+_sourcePos.left);Debug.write("sourceDim: "+sourceDim.width+" x "+sourceDim.height);Debug.write("menuDim: "+menuDim.height);Debug.write("screenDim: "+screenDim.height);Debug.write("manual ofset: "+this.options.offsetX+" x "+this.options.offsetY);_a=_source.getOffsetParent();_b=this.target.getOffsetParent();Debug.write("_a is "+_a);Debug.write("_b is "+_b);if(isFixed)
{$(this.target).setStyle('position: fixed');if((_sourcePos.left+menuDim.width)>screenDim.width){diff=menuDim.width-sourceDim.width;pos.left=_sourcePos.left-diff+this.options.offsetX;}else{pos.left=(_sourcePos.left)+this.options.offsetX;}
if((_sourcePos.top+menuDim.height)>screenDim.height){pos.top=_sourcePos.top-menuDim.height+this.options.offsetY;}else{pos.top=_sourcePos.top+sourceDim.height+this.options.offsetY;}
$(this.target).setStyle('top: '+(pos.top-1)+'px; left: '+pos.left+'px;');}
else
{if(_a!=_b)
{if((realSourcePos.left+menuDim.width)>screenDim.width){diff=menuDim.width-sourceDim.width;pos.left=_sourcePos.left-diff+this.options.offsetX;}else{if(Prototype.Browser.IE7){pos.left=(_sourcePos.left)+this.options.offsetX;}else{pos.left=(_sourcePos.left)+this.options.offsetX;}}
if((((realSourcePos.top+sourceDim.height)+menuDim.height)>screenDim.height)&&(_sourcePos.top-menuDim.height+this.options.offsetY)>0)
{pos.top=_sourcePos.top-menuDim.height+this.options.offsetY;}else{pos.top=_sourcePos.top+sourceDim.height+this.options.offsetY;}}
else
{Debug.write("MENU: source offset EQUALS target offset");if((realSourcePos.left+menuDim.width)>screenDim.width){diff=menuDim.width-sourceDim.width;pos.left=sourcePos.left-diff+this.options.offsetX;}else{pos.left=sourcePos.left+this.options.offsetX;}
if((((realSourcePos.top+sourceDim.height)+menuDim.height)>screenDim.height)&&(_sourcePos.top-menuDim.height+this.options.offsetY)>0)
{pos.top=sourcePos.top-menuDim.height+this.options.offsetY;}else{pos.top=sourcePos.top+sourceDim.height+this.options.offsetY;}}
$(this.target).setStyle('top: '+(pos.top-1)+'px; left: '+pos.left+'px;');}
$(this.source).addClassName('menu_active');Debug.write("Menu position: "+pos.top+" x "+pos.left);new Effect.Appear($(this.target),{duration:0.2,afterFinish:function(e){if(Object.isFunction(this.callbacks['afterOpen']))
{this.callbacks['afterOpen'](this);}}.bind(this)});Event.observe(document,'keypress',this.checkKeyPress.bindAsEventListener(this));},checkKeyPress:function(e)
{if(e.keyCode==Event.KEY_ESC)
{this.doClose();}},mouseOutClose:function()
{this.doClose();},doClose:function()
{new Effect.Fade($(this.target),{duration:0.3,afterFinish:function(e){if(Object.isFunction(this.callbacks['afterClose']))
{this.callbacks['afterClose'](this);}}.bind(this)});this.source.removeClassName('menu_active');},targetClick:function(e)
{if(!this.options.stopClose){this.doClose();}},eventClick:function(e,elem)
{if(this.options['eventType']=='click')
{Event.stop(e);if($(this.target).visible()){if(Object.isFunction(this.callbacks['beforeClose']))
{this.callbacks['beforeClose'](this);}
this.doClose();}else{ipb.menus.closeAll($(this.source).id);if(Object.isFunction(this.callbacks['beforeOpen']))
{this.callbacks['beforeOpen'](this);}
this.doOpen(elem);}}},eventOver:function()
{if(this.options['eventType']=='mouseover')
{if(!$(this.target).visible()){ipb.menus.closeAll($(this.source).id);if(Object.isFunction(this.callbacks['beforeOpen']))
{this.callbacks['beforeOpen'](this);}
this.doOpen();}}}});_popup=window.IPBoard;_popup.prototype.Popup=Class.create({initialize:function(id,options,callbacks)
{this.id='';this.wrapper=null;this.inner=null;this.stem=null;this.options={};this.timer=[];this.ready=false;this.visible=false;this._startup=null;this.hideAfterSetup=false;this.eventPairs={'mouseover':'mouseout','mousedown':'mouseup'};this._tmpEvent=null;this.id=id;this.options=Object.extend({type:'pane',w:'500px',modal:false,modalOpacity:0.4,hideAtStart:true,delay:{show:0,hide:0},defer:false,hideClose:false,black:false,warning:false,evalJs:true,evalScript:true,closeContents:ipb.templates['close_popup']},arguments[1]||{});this.callbacks=callbacks||{};if(this.options.defer&&$(this.options.attach.target))
{this._defer=this.init.bindAsEventListener(this);$(this.options.attach.target).observe(this.options.attach.event,this._defer);if(this.eventPairs[this.options.attach.event])
{this._startup=function(e){this.hideAfterSetup=true;this.hide();}.bindAsEventListener(this);$(this.options.attach.target).observe(this.eventPairs[this.options.attach.event],this._startup);}}
else
{this.init();}},init:function()
{try{Event.stopObserving($(this.options.attach.target),this.options.attach.event,this._defer);if($(this.options.attach.target))
{var toff=$(this.options.attach.target).positionedOffset();var menu=$(this.options.attach.target).up('.ipbmenu_content');if(toff.top==0&&toff.left==0||$(menu))
{this.options.type='modal';this.options.attach={};}}}catch(err){}
this.wrapper=new Element('div',{'id':this.id+'_popup'}).setStyle('z-index: 10001').hide().addClassName('popupWrapper');this.inner=new Element('div',{'id':this.id+'_inner'}).addClassName('popupInner');if(this.options.black)
{this.inner.addClassName('black_mode');}
if(this.options.warning)
{this.inner.addClassName('warning_mode');}
if(this.options.w){this.inner.setStyle('width: '+this.options.w);}
this.wrapper.insert(this.inner);if(this.options.hideClose!=true)
{this.closeLink=new Element('div',{'id':this.id+'_close'}).addClassName('popupClose').addClassName('clickable');this.closeLink.update(this.options.closeContents);this.closeLink.observe('click',this.hide.bindAsEventListener(this));this.wrapper.insert(this.closeLink);if(this.options.black||this.options.warning)
{this.closeLink.addClassName('light_close_button');}}
$$('body')[0].insert(this.wrapper);if(this.options.classname){this.wrapper.addClassName(this.options.classname);}
if(this.options.initial){this.update(this.options.initial,this.options.evalScript);}
if(Object.isFunction(this.callbacks['beforeAjax']))
{this.callbacks['beforeAjax'](this);}
if(this.options.ajaxURL){this.updateAjax();setTimeout(this.continueInit.bind(this),80);}else{this.ready=true;this.continueInit();}},continueInit:function()
{if(!this.ready)
{setTimeout(this.continueInit.bind(this),80);return;}
if(this.inner.select(".fixed_inner").size())
{Debug.write("Found fixed_inner");this.inner.select(".fixed_inner")[0].setStyle('height: '+this.options.h+'px; max-height: '+this.options.h+'px; overflow: auto');}
else
{var _vph=document.viewport.getDimensions().height-25;this.options.h=(this.options.h&&_vph>this.options.h)?this.options.h:_vph;this.inner.setStyle('max-height: '+this.options.h+'px');}
if(this.options.type=='balloon'){this.setUpBalloon();}else{this.setUpPane();}
try{if(this.options.close){closeElem=$(this.wrapper).select(this.options.close)[0];if(Object.isElement(closeElem))
{$(closeElem).observe('click',this.hide.bindAsEventListener(this));}}}catch(err){Debug.write(err);}
if(Object.isFunction(this.callbacks['afterInit']))
{this.callbacks['afterInit'](this);}
if(!this.options.hideAtStart&&!this.hideAfterSetup)
{this.show();}
if(this.hideAfterSetup&&this._startup)
{Event.stopObserving($(this.options.attach.target),this.eventPairs[this.options.attach.event],this._startup);}},updateAjax:function()
{Debug.write(this.options.ajaxURL);new Ajax.Request(this.options.ajaxURL,{method:'get',evalJS:this.options.evalJs,onSuccess:function(t)
{if(t.responseText!='error')
{try
{if(!Object.isUndefined(t.responseJSON)&&!Object.isUndefined(t.responseJSON['error']))
{if(t.responseJSON['__board_offline__'])
{ipb.global.errorDialogue(ipb.lang['board_offline']);ipb.menus.closeAll(e);}
else
{ipb.global.errorDialogue(t.responseJSON['error']);}
return false;}}catch(e){}
if(t.responseText=='nopermission')
{ipb.global.errorDialogue(ipb.lang['no_permission']);return;}
if(t.responseText.match("__session__expired__log__out__"))
{this.update('');alert(ipb.lang['session_timed_out']);return false;}
Debug.write("AJAX done!");this.update(t.responseText);this.ready=true;if(Object.isFunction(this.callbacks['afterAjax']))
{this.callbacks['afterAjax'](this,t.responseText);}}
else
{Debug.write(t.responseText);return;}}.bind(this)});},show:function(e)
{if(e){Event.stop(e);}
if(this.timer['show']){clearTimeout(this.timer['show']);}
if(this.options.delay.show!=0){this.timer['show']=setTimeout(this._show.bind(this),this.options.delay.show);}else{this._show();}},hide:function(e)
{if(e){Event.stop(e);}
if(this.document_event){Event.stopObserving(document,'click',this.document_event);Event.stopObserving(document,'touchstart',this.document_event);}
if(this.timer['hide']){clearTimeout(this.timer['hide']);}
if(this.options.delay.hide!=0){this.timer['hide']=setTimeout(this._hide.bind(this),this.options.delay.hide);}else{this._hide();}},kill:function()
{if(this.timer['hide']){clearTimeout(this.timer['hide']);}
if(this.timer['show']){clearTimeout(this.timer['show']);}
if($(this.wrapper))
{$(this.wrapper).remove();}},_show:function()
{this.visible=true;try
{if(this.options.warning)
{_wrap=this.inner.down('h3').next('div');if(_wrap)
{if(!_wrap.className.match(/moderated/))
{_wrap.addClassName('moderated');}}}}catch(e){}
if(this.options.modal==false){new Effect.Appear($(this.wrapper),{duration:0.3,afterFinish:function(){if(Object.isFunction(this.callbacks['afterShow']))
{this.callbacks['afterShow'](this);}}.bind(this)});this.document_event=this.handleDocumentClick.bindAsEventListener(this);this.setDocumentEvent();}else{new Effect.Appear($('document_modal'),{duration:0.3,to:this.options.modalOpacity,afterFinish:function(){new Effect.Appear($(this.wrapper),{duration:0.4,afterFinish:function(){if(Object.isFunction(this.callbacks['afterShow']))
{this.callbacks['afterShow'](this);}}.bind(this)});}.bind(this)});}},_hide:function()
{this.visible=false;if(this._tmpEvent!=null)
{Event.stopObserving($(this.wrapper),'mouseout',this._tmpEvent);this._tmpEvent=null;}
if(this.options.modal==false){new Effect.Fade($(this.wrapper),{duration:0.3,afterFinish:function(){if(Object.isFunction(this.callbacks['afterHide']))
{this.callbacks['afterHide'](this);}}.bind(this)});}else{new Effect.Fade($(this.wrapper),{duration:0.3,afterFinish:function(){new Effect.Fade($('document_modal'),{duration:0.2,afterFinish:function(){if(Object.isFunction(this.callbacks['afterHide']))
{this.callbacks['afterHide'](this);}}.bind(this)});}.bind(this)});}},setDocumentEvent:function()
{if(!ipb.vars['is_touch']){Event.observe(document,'click',this.document_event);return;}
Event.observe(document,'touchstart',this.document_event);},handleDocumentClick:function(e)
{Debug.write('document click: '+Event.element(e).id);if(!Event.element(e).descendantOf(this.wrapper)&&(this.options.attach&&(Event.element(e).id!=this.options.attach.target.id)))
{this.hide(e);}},update:function(content,evalScript)
{if(Object.isElement(content)){this.inner.insert({bottom:content});}else{this.inner.update(content);}
if(Object.isUndefined(evalScript)||evalScript!=false){this.inner.innerHTML.evalScripts();}},setUpBalloon:function()
{if(this.options.attach)
{var attach=this.options.attach;if(attach.target&&$(attach.target))
{if(this.options.stem==true)
{this.createStem();}
if(!attach.position){attach.position='auto';}
if(isRTL)
{if(Object.isUndefined(attach.offset)){attach.offset={top:0,right:0};}
if(Object.isUndefined(attach.offset.top)){attach.offset.top=0;}
if(Object.isUndefined(attach.offset.left)){attach.offset.right=0;}else{attach.offset.right=attach.offset.left;}}
else
{if(Object.isUndefined(attach.offset)){attach.offset={top:0,left:0};}
if(Object.isUndefined(attach.offset.top)){attach.offset.top=0;}
if(Object.isUndefined(attach.offset.left)){attach.offset.left=0;}}
if(attach.position=='auto')
{Debug.write("Popup: auto-positioning");var screendims=document.viewport.getDimensions();var screenscroll=document.viewport.getScrollOffsets();var toff=$(attach.target).viewportOffset();var wrapSize=$(this.wrapper).getDimensions();var delta=[0,0];if(Element.getStyle($(attach.target),'position')=='absolute')
{var parent=attach.target.getOffsetParent();delta=parent.viewportOffset();}
if(isRTL)
{toff['right']=screendims.width-(toff[0]-delta[0]);}
else
{toff['left']=toff[0]-delta[0];}
toff['top']=toff[1]-delta[1]+screenscroll.top;var start='top';if(isRTL){var end='right';}else{var end='left';}
if((toff.top-wrapSize.height-attach.offset.top)<(0+screenscroll.top)){var start='bottom';}
if(isRTL)
{if((toff.right+wrapSize.width-attach.offset.right)<(screendims.width-screenscroll.left)){var end='left';}}
else
{if((toff.left+wrapSize.width-attach.offset.left)>(screendims.width-screenscroll.left)){var end='right';}}
finalPos=this.position(start+end,{target:$(attach.target),content:$(this.wrapper),offset:attach.offset});if(this.options.stem==true)
{finalPos=this.positionStem(start+end,finalPos);}}
else
{Debug.write("Popup: manual positioning");finalPos=this.position(attach.position,{target:$(attach.target),content:$(this.wrapper),offset:attach.offset});if(this.options.stem==true)
{finalPos=this.positionStem(attach.position,finalPos);}}
if(!Object.isUndefined(attach.event)){$(attach.target).observe(attach.event,this.show.bindAsEventListener(this));if(attach.event!='click'&&!Object.isUndefined(this.eventPairs[attach.event])){$(attach.target).observe(this.eventPairs[attach.event],this.hide.bindAsEventListener(this));}
$(this.wrapper).observe('mouseover',this.wrapperEvent.bindAsEventListener(this));}}}
if(isRTL)
{Debug.write("Popup: Right: "+finalPos.right+"; Top: "+finalPos.top);$(this.wrapper).setStyle('top: '+finalPos.top+'px; right: '+finalPos.right+'px; position: absolute;');}
else
{Debug.write("Popup: Left: "+finalPos.left+"; Top: "+finalPos.top);$(this.wrapper).setStyle('top: '+finalPos.top+'px; left: '+finalPos.left+'px; position: absolute;');}},wrapperEvent:function(e)
{if(this.timer['hide'])
{clearTimeout(this.timer['hide']);this.timer['hide']=null;if(this.options.attach.event&&this.options.attach.event=='mouseover')
{if(this._tmpEvent==null){this._tmpEvent=this.hide.bindAsEventListener(this);$(this.wrapper).observe('mouseout',this._tmpEvent);}}}},positionStem:function(pos,finalPos)
{var stemSize={height:16,width:31};var wrapStyle={};var stemStyle={};switch(pos.toLowerCase())
{case'topleft':wrapStyle={marginBottom:stemSize.height+'px'};if(isRTL)
{stemStyle={bottom:-(stemSize.height)+'px',right:'5px'};finalPos.right=finalPos.right-15;}
else
{stemStyle={bottom:-(stemSize.height)+'px',left:'5px'};finalPos.left=finalPos.left-15;}
break;case'topright':wrapStyle={marginBottom:stemSize.height+'px'};if(isRTL)
{stemStyle={bottom:-(stemSize.height)+'px',left:'5px'};finalPos.right=finalPos.right+15;}
else
{stemStyle={bottom:-(stemSize.height)+'px',right:'5px'};finalPos.left=finalPos.left+15;}
break;case'bottomleft':wrapStyle={marginTop:stemSize.height+'px'};if(isRTL)
{stemStyle={top:-(stemSize.height)+'px',right:'5px'};finalPos.right=finalPos.right-15;}
else
{stemStyle={top:-(stemSize.height)+'px',left:'5px'};finalPos.left=finalPos.left-15;}
break;case'bottomright':wrapStyle={marginTop:stemSize.height+'px'};if(isRTL)
{stemStyle={top:-(stemSize.height)+'px',left:'5px'};finalPos.right=finalPos.right+15;}
else
{stemStyle={top:-(stemSize.height)+'px',right:'5px'};finalPos.left=finalPos.left+15;}
break;}
$(this.wrapper).setStyle(wrapStyle);$(this.stem).setStyle(stemStyle).setStyle('z-index: 6000').addClassName(pos.toLowerCase());return finalPos;},position:function(pos,v)
{finalPos={};v.target.identify();var toff=$(v.target.id).viewportOffset();var tsize=$(v.target.id).getDimensions();var wrapSize=$(v.content).getDimensions();var screenscroll=document.viewport.getScrollOffsets();var offset=v.offset;var delta=[0,0];if(Element.getStyle($(v.target.id),'position')=='absolute')
{var parent=$(v.target.id).getOffsetParent();delta=parent.viewportOffset();delta=[0,0];}
if(isRTL)
{toff['right']=document.viewport.getDimensions().width-(toff[0]-delta[0]);}
else
{toff['left']=toff[0]-delta[0];}
toff['top']=toff['top']-delta[1]+screenscroll.top;switch(pos.toLowerCase())
{case'topleft':finalPos.top=(toff.top-wrapSize.height-(tsize.height/2))-offset.top;if(isRTL)
{finalPos.right=toff.right+offset.right;}
else
{finalPos.left=toff.left+offset.left;}
break;case'topright':finalPos.top=(toff.top-wrapSize.height-(tsize.height/2))-offset.top;if(isRTL)
{finalPos.right=(toff.right-(wrapSize.width-tsize.width))-offset.right;}
else
{finalPos.left=(toff.left-(wrapSize.width-tsize.width))-offset.left;}
break;case'bottomleft':finalPos.top=(toff.top+tsize.height)+offset.top;if(isRTL)
{finalPos.right=toff.right+offset.right;}
else
{finalPos.left=toff.left+offset.left;}
break;case'bottomright':finalPos.top=(toff.top+tsize.height)+offset.top;if(isRTL)
{finalPos.right=(toff.right-(wrapSize.width-tsize.width))-offset.right;}
else
{finalPos.left=(toff.left-(wrapSize.width-tsize.width))-offset.left;}
break;}
return finalPos;},createStem:function()
{this.stem=new Element('div',{id:this.id+'_stem'}).update('&nbsp;').addClassName('stem');this.wrapper.insert({top:this.stem});},setUpPane:function()
{if(!$('document_modal')){this.createDocumentModal();}
this.positionPane();},positionPane:function()
{var elem_s=$(this.wrapper).getDimensions();var window_s=document.viewport.getDimensions();var window_offsets=document.viewport.getScrollOffsets();if(ipb.vars['is_touch']){window_s={width:window.innerWidth,height:window.innerHeight};}
if(isRTL)
{var center={right:((window_s['width']-elem_s['width'])/2),top:(((window_s['height']-elem_s['height'])/2)/2)};if(center.top<10){center.top=10;}
$(this.wrapper).setStyle('top: '+center['top']+'px; right: '+center['right']+'px; position: fixed;');}
else
{var center={left:((window_s['width']-elem_s['width'])/2),top:(((window_s['height']-elem_s['height'])/2)/2)};if(center.top<10){center.top=10;}
$(this.wrapper).setStyle('top: '+center['top']+'px; left: '+center['left']+'px; position: fixed;');}},createDocumentModal:function()
{var pageLayout=$(document.body).getLayout();var pageSize={width:pageLayout.get('width'),height:pageLayout.get('margin-box-height')};var viewSize=document.viewport.getDimensions();var dims=[];Debug.dir(pageSize);Debug.dir(viewSize);if(viewSize['height']<pageSize['height']){dims['height']=pageSize['height'];}else{dims['height']=viewSize['height'];}
if(viewSize['width']<pageSize['width']){dims['width']=pageSize['width'];}else{dims['width']=viewSize['width'];}
var modal=new Element('div',{'id':'document_modal'}).addClassName('modal').hide();if(isRTL){modal.setStyle('width: '+dims['width']+'px; height: '+dims['height']+'px; position: fixed; top: 0px; right: 0px; z-index: 10000;');}else{modal.setStyle('width: '+dims['width']+'px; height: '+dims['height']+'px; position: fixed; top: 0px; left: 0px; z-index: 10000;');}
$$('body')[0].insert(modal);},getObj:function()
{return $(this.wrapper);}});_ticker=window.IPBoard;_ticker.prototype.Ticker=Class.create({initialize:function(root,options,callbacks)
{if(!$(root)){return;}
this.root=$(root);this.options=Object.extend({duration:4,select:"li"},options||{});this.items=$(root).select(this.options.select);if(!this.items.length){return;}
this.items.invoke('hide').first().show();this.timer=this.nextItem.bind(this).delay(this.options.duration);$(this.root).observe('mouseenter',this.pauseTicker.bindAsEventListener(this));$(this.root).observe('mouseleave',this.unpauseTicker.bindAsEventListener(this));},pauseTicker:function(e)
{clearTimeout(this.timer);},unpauseTicker:function(e)
{this.timer=this.nextItem.bind(this).delay(this.options.duration);},nextItem:function()
{var cur=this.items.find(function(elem){return elem.visible();});var next=$(cur).next(this.options.select);if(Object.isUndefined(next)){next=this.items.first();}
new Effect.Fade($(cur),{duration:0.4,queue:'end',afterFinish:function(){new Effect.Appear($(next),{duration:0.8,queue:'end'});}});this.timer=this.nextItem.bind(this).delay(this.options.duration);}});function warningPopup(elem,id)
{var _url=ipb.vars['base_url']+'&app=members&module=ajax&secure_key='+ipb.vars['secure_hash']+'&section=warnings&id='+id;new ipb.Popup('warning'+id,{type:'balloon',stem:true,attach:{target:elem,position:'auto'},hideAtStart:false,ajaxURL:_url,w:'600px',h:800});}
ipb=new IPBoard;ipb.global.init();ipb.menus.init();;ipb.lang['action_failed']="Action failed";ipb.lang['ajax_failure']="Sorry that action failed";ipb.lang['album_full']="You are not permitted to upload any more items into this album";ipb.lang['approve']="Approve";ipb.lang['att_select_files']="Select files";ipb.lang['available']="&#10004; Available!";ipb.lang['bbc_date_cite']="From {date}:";ipb.lang['bbc_full_cite']="{author}, on {date}, said:";ipb.lang['bbc_name_cite']="{author} said:";ipb.lang['blog_cat_exists']="That category already exists";ipb.lang['blog_disable']="Disable";ipb.lang['blog_enable']="Enable";ipb.lang['blog_pin']="Pin";ipb.lang['blog_publish_now']="Publish Now";ipb.lang['blog_revert_header']="Are you sure you want to revert your header?";ipb.lang['blog_save_draft']="Save Draft";ipb.lang['blog_uncategorized']="Uncategorized";ipb.lang['blog_unpin']="Unpin";ipb.lang['board_offline']="This feature is unavailable while the board is offline";ipb.lang['cannot_readd_friend']="You cannot re-add this friend for five minutes after removing them";ipb.lang['cant_delete_folder']="You can't delete a protected folder!";ipb.lang['ckcolor__aliceblue']="Alice Blue";ipb.lang['ckcolor__antique']="Antique White";ipb.lang['ckcolor__azure']="Azure";ipb.lang['ckcolor__black']="Black";ipb.lang['ckcolor__blue']="Blue";ipb.lang['ckcolor__brown']="Brown";ipb.lang['ckcolor__cyan']="Cyan";ipb.lang['ckcolor__darkgray']="Dark Gray";ipb.lang['ckcolor__darkgreen']="Dark Green";ipb.lang['ckcolor__darkorange']="Dark Orange";ipb.lang['ckcolor__dimgray']="Dim Gray";ipb.lang['ckcolor__dsgray']="Dark Slate Gray";ipb.lang['ckcolor__firebrick']="Fire Brick";ipb.lang['ckcolor__gold']="Gold";ipb.lang['ckcolor__goldenrod']="Golden Rod";ipb.lang['ckcolor__gray']="Gray";ipb.lang['ckcolor__green']="Green";ipb.lang['ckcolor__honeydew']="Honeydew";ipb.lang['ckcolor__indigo']="Indigo";ipb.lang['ckcolor__lavender']="Lavender Blush";ipb.lang['ckcolor__lightblue']="Light Blue";ipb.lang['ckcolor__lightgray']="Light Gray";ipb.lang['ckcolor__lightsalmon']="Light Salmon";ipb.lang['ckcolor__lightyellow']="Light Yellow";ipb.lang['ckcolor__lime']="Lime";ipb.lang['ckcolor__maroon']="Maroon";ipb.lang['ckcolor__medblue']="Medium Blue";ipb.lang['ckcolor__navy']="Navy";ipb.lang['ckcolor__orange']="Orange";ipb.lang['ckcolor__paleturq']="Pale Turquoise";ipb.lang['ckcolor__plum']="Plum";ipb.lang['ckcolor__purple']="Purple";ipb.lang['ckcolor__red']="Red";ipb.lang['ckcolor__reglavender']="Lavender";ipb.lang['ckcolor__sadbrown']="Saddle Brown";ipb.lang['ckcolor__teal']="Teal";ipb.lang['ckcolor__turquoise']="Turquoise";ipb.lang['ckcolor__violet']="Violet";ipb.lang['ckcolor__white']="White";ipb.lang['ckcolor__yellow']="Yellow";ipb.lang['ckeditor__about']="About";ipb.lang['ckeditor__aboutscayt']="About SCAYT";ipb.lang['ckeditor__about_ck']="About CKEditor";ipb.lang['ckeditor__accesskey']="Access Key";ipb.lang['ckeditor__address']="Address";ipb.lang['ckeditor__add_word']="Add Word";ipb.lang['ckeditor__advanced']="Advanced";ipb.lang['ckeditor__advisorytitle']="Advisory Title";ipb.lang['ckeditor__advisorytype']="Advisory Content Type";ipb.lang['ckeditor__alignleft']="Align Left";ipb.lang['ckeditor__alignment']="Alignment";ipb.lang['ckeditor__alignright']="Align Right";ipb.lang['ckeditor__alt_text']="Alternative Text";ipb.lang['ckeditor__anchor']="Anchor";ipb.lang['ckeditor__anchorlink']="Link to anchor in the text";ipb.lang['ckeditor__anchorname']="Anchor Name";ipb.lang['ckeditor__anchorprop']="Anchor Properties";ipb.lang['ckeditor__armeniannumb']="Armenian numbering";ipb.lang['ckeditor__automatic']="Automatic";ipb.lang['ckeditor__bbcode']="Special BBCode";ipb.lang['ckeditor__bbcodelabel']="BBCode";ipb.lang['ckeditor__bg_color']="Background Color";ipb.lang['ckeditor__bidiltr']="Text direction from left to right";ipb.lang['ckeditor__bidirtl']="Text direction from right to left";ipb.lang['ckeditor__blockquote']="Block Quote";ipb.lang['ckeditor__block_styles']="Block Styles";ipb.lang['ckeditor__bold']="Bold";ipb.lang['ckeditor__border']="Border";ipb.lang['ckeditor__border_nan']="Border must be a whole number.";ipb.lang['ckeditor__bottom']="Bottom";ipb.lang['ckeditor__browse_server']="Browse Server";ipb.lang['ckeditor__bulletlist']="Bulleted List Properties";ipb.lang['ckeditor__button']="Button";ipb.lang['ckeditor__buttontoimage']="Do you want to transform the selected image button to a simple image?";ipb.lang['ckeditor__byanchorname']="By Anchor Name";ipb.lang['ckeditor__byelementid']="By Element Id";ipb.lang['ckeditor__byemailaddy']="E-Mail Address";ipb.lang['ckeditor__cancel']="Cancel";ipb.lang['ckeditor__center']="Center";ipb.lang['ckeditor__checkbox']="Checkbox";ipb.lang['ckeditor__circle']="Circle";ipb.lang['ckeditor__clean_word']="The text you want to paste seems to be copied from Word. Do you want to clean it before pasting?";ipb.lang['ckeditor__clear']="Clear";ipb.lang['ckeditor__close']="Close";ipb.lang['ckeditor__codelabel']="Code";ipb.lang['ckeditor__codetypelabel']="Code Type";ipb.lang['ckeditor__code_css']="CSS";ipb.lang['ckeditor__code_generic']="PHP/Generic/Auto Detect";ipb.lang['ckeditor__code_html']="HTML";ipb.lang['ckeditor__code_js']="Javascript";ipb.lang['ckeditor__code_linenum']="Starting Line Number";ipb.lang['ckeditor__code_none']="None";ipb.lang['ckeditor__code_sql']="SQL";ipb.lang['ckeditor__code_title']="Code";ipb.lang['ckeditor__code_xml']="XML";ipb.lang['ckeditor__collapsetools']="Collapse Toolbar";ipb.lang['ckeditor__colors']="Colors";ipb.lang['ckeditor__color_options']="Color Options";ipb.lang['ckeditor__confirmcancel']="Some of the options have been changed. Are you sure to close the dialog?";ipb.lang['ckeditor__confirmreload']="Any unsaved changes to this content will be lost. Are you sure you want to load new page?";ipb.lang['ckeditor__contenttemps']="Content Templates";ipb.lang['ckeditor__contextmenopt']="Context Menu Options";ipb.lang['ckeditor__copy']="Copy";ipb.lang['ckeditor__copyright']="Copyright &copy; $1. All rights reserved.";ipb.lang['ckeditor__create']="Create";ipb.lang['ckeditor__css_classes']="Stylesheet Classes";ipb.lang['ckeditor__cut']="Cut";ipb.lang['ckeditor__decimal']="Decimal (1, 2, 3, etc.)";ipb.lang['ckeditor__decimal_zero']="Decimal leading zero (01, 02, 03, etc.)";ipb.lang['ckeditor__dec_indent']="Decrease Indent";ipb.lang['ckeditor__delete']="Delete";ipb.lang['ckeditor__dictionaries']="Dictionaries";ipb.lang['ckeditor__diction_name']="Dictionary name";ipb.lang['ckeditor__dict_cookie']="Initially the User Dictionary is stored in a Cookie. However, Cookies are limited in size. When the User Dictionary grows to a point where it cannot be stored in a Cookie, then the dictionary may be stored on our server. To store your personal dictionary on our server you should specify a name for your dictionary. If you already have a stored dictionary, please type its name and click the Restore button.";ipb.lang['ckeditor__dict_name']="Dictionary name should not be empty.";ipb.lang['ckeditor__disablescayt']="Disable SCAYT";ipb.lang['ckeditor__disc']="Disc";ipb.lang['ckeditor__divcontainer']="Create Div Container";ipb.lang['ckeditor__dragtoresize']="Drag to resize";ipb.lang['ckeditor__editanchor']="Edit Anchor";ipb.lang['ckeditor__editlink']="Edit Link";ipb.lang['ckeditor__editor']="Rich Text Editor";ipb.lang['ckeditor__edit_div']="Edit Div";ipb.lang['ckeditor__elementspath']="Elements path";ipb.lang['ckeditor__emailbody']="Message Body";ipb.lang['ckeditor__emaillink']="E-mail";ipb.lang['ckeditor__emailsubject']="Message Subject";ipb.lang['ckeditor__emoticons']="Emoticons";ipb.lang['ckeditor__enablescayt']="Enable SCAYT";ipb.lang['ckeditor__expandtools']="Expand Toolbar";ipb.lang['ckeditor__find']="Find";ipb.lang['ckeditor__findreplace']="Find and Replace";ipb.lang['ckeditor__find_what']="Find what:";ipb.lang['ckeditor__flash']="Flash";ipb.lang['ckeditor__flashanima']="Flash Animation";ipb.lang['ckeditor__flash_prop']="Flash Properties";ipb.lang['ckeditor__font']="Font";ipb.lang['ckeditor__font_name']="Font Name";ipb.lang['ckeditor__font_size']="Font Size";ipb.lang['ckeditor__form']="Form";ipb.lang['ckeditor__formaat']="Format";ipb.lang['ckeditor__formatted']="Formatted";ipb.lang['ckeditor__format_styles']="Formatting Styles";ipb.lang['ckeditor__framelink']="<frame>";ipb.lang['ckeditor__gencontent']="Content";ipb.lang['ckeditor__general']="General";ipb.lang['ckeditor__genoption']="Option";ipb.lang['ckeditor__georgiannumb']="Georgian numbering (an, ban, gan, etc.)";ipb.lang['ckeditor__heading']="Heading";ipb.lang['ckeditor__height']="Height";ipb.lang['ckeditor__height_nan']="Height must be a number.";ipb.lang['ckeditor__hiddenfield']="Hidden Field";ipb.lang['ckeditor__highlight']="Highlight";ipb.lang['ckeditor__hr']="Insert Horizontal Line";ipb.lang['ckeditor__hspace']="HSpace";ipb.lang['ckeditor__hspace_nan']="HSpace must be a whole number.";ipb.lang['ckeditor__id']="Id";ipb.lang['ckeditor__iframe']="iFrame";ipb.lang['ckeditor__iframeborder']="Show frame border";ipb.lang['ckeditor__iframeprops']="iFrame Properties";ipb.lang['ckeditor__iframescroll']="Enable scrollbars";ipb.lang['ckeditor__iframeurl']="Please type the iFrame URL";ipb.lang['ckeditor__ignore']="Ignore";ipb.lang['ckeditor__ignoreallcaps']="Ignore All-Caps Words";ipb.lang['ckeditor__ignoredomains']="Ignore Domain Names";ipb.lang['ckeditor__ignoremixedc']="Ignore Words with Mixed Case";ipb.lang['ckeditor__ignorewnumber']="Ignore Words with Numbers";ipb.lang['ckeditor__ignore_all']="Ignore All";ipb.lang['ckeditor__image']="Image";ipb.lang['ckeditor__imagebutton']="Image Button";ipb.lang['ckeditor__imagebutton_p']="Image Button Properties";ipb.lang['ckeditor__imagetobutton']="Do you want to transform the selected image to a image button?";ipb.lang['ckeditor__image_info']="Image Info";ipb.lang['ckeditor__image_prop']="Image Properties";ipb.lang['ckeditor__image_url']="Please type the image URL";ipb.lang['ckeditor__inc_indent']="Increase Indent";ipb.lang['ckeditor__inlinestyle']="Inline Style";ipb.lang['ckeditor__inline_styles']="Inline Styles";ipb.lang['ckeditor__insdelbullist']="Insert/Remove Bulleted List";ipb.lang['ckeditor__insdelnumlist']="Insert/Remove Numbered List";ipb.lang['ckeditor__insertsmilie']="Insert a Smiley";ipb.lang['ckeditor__insertspecial']="Insert Special Character";ipb.lang['ckeditor__italic']="Italic";ipb.lang['ckeditor__justify']="Justify";ipb.lang['ckeditor__langcode']="Language Code";ipb.lang['ckeditor__languagedir']="Language Direction";ipb.lang['ckeditor__languages']="Languages";ipb.lang['ckeditor__left']="Left";ipb.lang['ckeditor__licvisitsite']="For licensing information please visit our web site:";ipb.lang['ckeditor__link']="Link";ipb.lang['ckeditor__linked_char']="Linked Resource Charset";ipb.lang['ckeditor__linkother']="<other>";ipb.lang['ckeditor__link_info']="Link Info";ipb.lang['ckeditor__link_type']="Link Type";ipb.lang['ckeditor__list_nan']="List start number must be a whole number.";ipb.lang['ckeditor__lock_ratio']="Lock Ratio";ipb.lang['ckeditor__longdescurl']="Long Description URL";ipb.lang['ckeditor__loweralpha']="Lower Alpha (a, b, c, d, e, etc.)";ipb.lang['ckeditor__lowergreek']="Lower Greek (alpha, beta, gamma, etc.)";ipb.lang['ckeditor__lowerroman']="Lower Roman (i, ii, iii, iv, v, etc.)";ipb.lang['ckeditor__ltrlang']="Left to Right (LTR)";ipb.lang['ckeditor__match_case']="Match case";ipb.lang['ckeditor__match_cyclic']="Match cyclic";ipb.lang['ckeditor__match_word']="Match whole word";ipb.lang['ckeditor__maximize']="Maximize";ipb.lang['ckeditor__middle']="Middle";ipb.lang['ckeditor__minimize']="Minimize";ipb.lang['ckeditor__missingimgurl']="Image source URL is missing.";ipb.lang['ckeditor__moresuggs']="More suggestions";ipb.lang['ckeditor__more_colors']="More Colors...";ipb.lang['ckeditor__mymedia']="My Media";ipb.lang['ckeditor__name']="Name";ipb.lang['ckeditor__nan']="This value is not a number.";ipb.lang['ckeditor__newpage']="New Page";ipb.lang['ckeditor__noanchorsa']="(No anchors available in the document)";ipb.lang['ckeditor__nocleanword']="It was not possible to clean up the pasted data due to an internal error";ipb.lang['ckeditor__none']="None";ipb.lang['ckeditor__nooperalol']="Not supported by Opera";ipb.lang['ckeditor__normal']="Normal";ipb.lang['ckeditor__normal_div']="Normal (DIV)";ipb.lang['ckeditor__notemplates']="(No templates defined)";ipb.lang['ckeditor__notset']="<not set>";ipb.lang['ckeditor__numberedlist']="Numbered List Properties";ipb.lang['ckeditor__object_styles']="Object Styles";ipb.lang['ckeditor__ok']="OK";ipb.lang['ckeditor__options']="Options";ipb.lang['ckeditor__para_format']="Paragraph Format";ipb.lang['ckeditor__paste']="Paste";ipb.lang['ckeditor__paste_area']="Paste Area";ipb.lang['ckeditor__paste_box']="Please paste inside the following box using the keyboard (<strong>Ctrl/Cmd+V</strong>) and hit OK";ipb.lang['ckeditor__paste_err1']="Your browser security settings don\\'t permit the editor to automatically execute cutting operations. Please use the keyboard for that (Ctrl/Cmd+X).";ipb.lang['ckeditor__paste_err2']="Your browser security settings don\\'t permit the editor to automatically execute copying operations. Please use the keyboard for that (Ctrl/Cmd+C).";ipb.lang['ckeditor__paste_err3']="Because of your browser security settings, the editor is not able to access your clipboard data directly. You are required to paste it again in this window.";ipb.lang['ckeditor__paste_ptext']="Paste as Plain Text";ipb.lang['ckeditor__paste_word']="Paste from Word";ipb.lang['ckeditor__pb']="Insert Page Break for Printing";ipb.lang['ckeditor__pba']="Page Break";ipb.lang['ckeditor__popupdepend']="Dependent (Netscape)";ipb.lang['ckeditor__popupfeat']="Popup Window Features";ipb.lang['ckeditor__popupfullscr']="Full Screen (IE)";ipb.lang['ckeditor__popupleftpos']="Left Position";ipb.lang['ckeditor__popuplink']="<popup window>";ipb.lang['ckeditor__popuplocation']="Location Bar";ipb.lang['ckeditor__popupmenubar']="Menu Bar";ipb.lang['ckeditor__popupresize']="Resizable";ipb.lang['ckeditor__popupscroll']="Scroll Bars";ipb.lang['ckeditor__popupstatusba']="Status Bar";ipb.lang['ckeditor__popuptoolbar']="Toolbar";ipb.lang['ckeditor__popuptoppos']="Top Position";ipb.lang['ckeditor__popupwinname']="Popup Window Name";ipb.lang['ckeditor__preview']="Preview";ipb.lang['ckeditor__print']="Print";ipb.lang['ckeditor__properties']="Properties";ipb.lang['ckeditor__protocol']="Protocol";ipb.lang['ckeditor__pselectbbcode']="Please select";ipb.lang['ckeditor__quotelabel']="Quote";ipb.lang['ckeditor__radiobutton']="Radio Button";ipb.lang['ckeditor__redo']="Redo";ipb.lang['ckeditor__removeformat']="Remove Format";ipb.lang['ckeditor__remove_div']="Remove Div";ipb.lang['ckeditor__rename']="Rename";ipb.lang['ckeditor__repactconts']="Replace actual contents";ipb.lang['ckeditor__replace']="Replace";ipb.lang['ckeditor__replace_all']="Replace All";ipb.lang['ckeditor__replace_cnt']="%1 occurrence(s) replaced.";ipb.lang['ckeditor__replace_with']="Replace with:";ipb.lang['ckeditor__reset_size']="Reset Size";ipb.lang['ckeditor__restore']="Restore";ipb.lang['ckeditor__right']="Right";ipb.lang['ckeditor__rtllang']="Right to Left (RTL)";ipb.lang['ckeditor__save']="Save";ipb.lang['ckeditor__scayt']="Spell Check As You Type";ipb.lang['ckeditor__selectall']="Select All";ipb.lang['ckeditor__selectanchor']="Select an Anchor";ipb.lang['ckeditor__selectcolor']="Select color";ipb.lang['ckeditor__selectedcolor']="Selected Color";ipb.lang['ckeditor__selectfield']="Selection Field";ipb.lang['ckeditor__selectspecial']="Select Special Character";ipb.lang['ckeditor__server_send']="Send it to the Server";ipb.lang['ckeditor__show_blocks']="Show Blocks";ipb.lang['ckeditor__size']="Size";ipb.lang['ckeditor__smiley']="Smiley";ipb.lang['ckeditor__smileyopts']="Smiley Options";ipb.lang['ckeditor__speccharopts']="Special Character Options";ipb.lang['ckeditor__square']="Square";ipb.lang['ckeditor__start']="Start";ipb.lang['ckeditor__strike']="Strike Through";ipb.lang['ckeditor__style']="Style";ipb.lang['ckeditor__styles']="Styles";ipb.lang['ckeditor__subscript']="Subscript";ipb.lang['ckeditor__superscript']="Superscript";ipb.lang['ckeditor__tab_index']="Tab Index";ipb.lang['ckeditor__target']="Target";ipb.lang['ckeditor__targframename']="Target Frame Name";ipb.lang['ckeditor__templateopts']="Template Options";ipb.lang['ckeditor__templates']="Templates";ipb.lang['ckeditor__textarea']="Textarea";ipb.lang['ckeditor__textfield']="Text Field";ipb.lang['ckeditor__text_color']="Text Color";ipb.lang['ckeditor__text_notfound']="The specified text was not found.";ipb.lang['ckeditor__tnewwindow']="New Window (_blank)";ipb.lang['ckeditor__togglelabel']="Toggle editing mode";ipb.lang['ckeditor__togglescayt']="Toggle SCAYT";ipb.lang['ckeditor__toolbar']="Toolbar";ipb.lang['ckeditor__top']="Top";ipb.lang['ckeditor__tparentwindow']="Parent Window (_parent)";ipb.lang['ckeditor__tsamewindow']="Same Window (_self)";ipb.lang['ckeditor__ttopwindow']="Topmost Window (_top)";ipb.lang['ckeditor__type']="Type";ipb.lang['ckeditor__typeanchor']="Please type the anchor name";ipb.lang['ckeditor__type_email']="Please type the e-mail address";ipb.lang['ckeditor__type_url']="Please type the link URL";ipb.lang['ckeditor__unavailable']="unavailable";ipb.lang['ckeditor__underline']="Underline";ipb.lang['ckeditor__undo']="Undo";ipb.lang['ckeditor__unknownobj']="Unknown Object";ipb.lang['ckeditor__unlink']="Unlink";ipb.lang['ckeditor__unlock_ratio']="Unlock Ratio";ipb.lang['ckeditor__upload']="Upload";ipb.lang['ckeditor__upperalpha']="Upper Alpha (A, B, C, D, E, etc.)";ipb.lang['ckeditor__upperroman']="Upper Roman (I, II, III, IV, V, etc.)";ipb.lang['ckeditor__url']="URL";ipb.lang['ckeditor__value']="Value";ipb.lang['ckeditor__vspace']="VSpace";ipb.lang['ckeditor__vspace_nan']="VSpace must be a whole number.";ipb.lang['ckeditor__whichtempl']="Please select the template to open in the editor";ipb.lang['ckeditor__width']="Width";ipb.lang['ckeditor__width_nan']="Width must be a number.";ipb.lang['ckeditor__xelements']="%1 element";ipb.lang['ck_auto_saved']="Last auto saved: #{time}";ipb.lang['ck_restore']="Restore Content";ipb.lang['ck_saved']="Saved Content";ipb.lang['ck_saved_desc']="As you type, the text editor content is automatically saved so that if you had to reload this page you can restore what you've written so far.";ipb.lang['ck_saved_title']="About Saved Content";ipb.lang['ck_view_saved']="View Auto Saved Content (#{updatedDate})";ipb.lang['clear_markboard']="Are you sure you want to mark all content as read?";ipb.lang['click_to_attach']="Choose Files...";ipb.lang['click_to_show_opts']="Click to configure post options";ipb.lang['close_tpreview']="Close preview";ipb.lang['comment_requires_approval']="Your comment requires moderator approval before it will be shown.";ipb.lang['confirm_delete']="Are you sure you want to delete this folder? ALL messages in it will be deleted. This cannot be undone!";ipb.lang['confirm_empty']="Are you sure you want to empty this folder?";ipb.lang['copy_topic_link']="Copy the permalink below to store the direct address to this post in your clipboard";ipb.lang['cpt_approve']="Approve";ipb.lang['cpt_approve_f']="Approve";ipb.lang['cpt_close_f']="Lock";ipb.lang['cpt_delete']="Delete";ipb.lang['cpt_delete_f']="Delete";ipb.lang['cpt_hide']="Hide";ipb.lang['cpt_hide_f']="Hide";ipb.lang['cpt_merge']="Merge";ipb.lang['cpt_merge_f']="Merge";ipb.lang['cpt_move']="Move";ipb.lang['cpt_move_f']="Move";ipb.lang['cpt_open_f']="Unlock";ipb.lang['cpt_pin_f']="Pin";ipb.lang['cpt_split']="Split";ipb.lang['cpt_undelete']="Unhide";ipb.lang['cpt_unhide_f']="Unhide";ipb.lang['cpt_unpin_f']="Unpin";ipb.lang['date_am']="AM";ipb.lang['date_pm']="PM";ipb.lang['delete_confirm']="Are you sure you want to continue?";ipb.lang['delete_pm_confirm']="Are you sure you wish to permanently delete this conversation?";ipb.lang['delete_pm_many_confirm']="Are you sure you wish to delete these conversations?";ipb.lang['delete_post_confirm']="Are you sure you want to delete this post?";ipb.lang['delete_reply_confirm']="Are you sure you want to delete this reply?";ipb.lang['delete_topic_confirm']="Are you sure you want to delete this topic?";ipb.lang['editor_enter_list']="Enter list item (or hit Cancel to finish list)";ipb.lang['editor_prefs_updated']="Options saved. Changes will take affect from the next editor load";ipb.lang['email_banned']="&#10007; This email address has been banned";ipb.lang['email_doesnt_match']="&#10007; The addresses you entered don't match";ipb.lang['email_in_use']="&#10007; This email address is in use";ipb.lang['emo_show_all']="Show All";ipb.lang['enter_unlimited_names']="Enter names";ipb.lang['enter_x_names']="Enter up to [x] names";ipb.lang['error']="Error";ipb.lang['error_occured']="An error occurred";ipb.lang['error_security']="Security Error";ipb.lang['fail_cblock']="Failed to save content block changes";ipb.lang['fail_config']="Failed to save configuration";ipb.lang['folder_emptied']="Folder emptied successfully";ipb.lang['folder_not_found']="Cannot find that folder";ipb.lang['folder_protected']="Cannot perform that action on a protected folder";ipb.lang['follow_action_saved']="Your preferences have been saved";ipb.lang['follow_no_action']="You did not select any action to perform";ipb.lang['friend_already']="This member is already on your friends list";ipb.lang['from']="From";ipb.lang['gallery_rotate_failed']="There was an error rotating the image";ipb.lang['gbl_confirm_cancel']="Cancel";ipb.lang['gbl_confirm_desc']="Please confirm this action";ipb.lang['gbl_confirm_ok']="OK";ipb.lang['gbl_confirm_text']="Confirm";ipb.lang['gbl_months']="Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sept,Oct,Nov,Dec";ipb.lang['global_leave_msg']="Leave a message...";ipb.lang['global_status_update']="What's on your mind?";ipb.lang['go_to_category']="Go to this category";ipb.lang['hide']="&times;";ipb.lang['idm_comment_empty']="Comment is empty";ipb.lang['idm_invalid_file']="Invalid File";ipb.lang['idm_msg_email']="You did not enter an email address to send the email to";ipb.lang['idm_msg_text']="You did not enter any text to email to the user";ipb.lang['invalid_chars']="&#10007; This field contains invalid characters";ipb.lang['invalid_email']="&#10007; This isn't a valid address";ipb.lang['invalid_folder_name']="The folder name is invalid";ipb.lang['invalid_mime_type']="You aren't permitted to upload this kind of file";ipb.lang['is_required']="&#10007; This field is required";ipb.lang['is_spammer']="This account has been flagged as a spam account";ipb.lang['js_rte_erroriespell']="ieSpell was not detected. Click OK to go to the download page.";ipb.lang['js_rte_errorloadingiespell']="Error loading ieSpell. Exception: ";ipb.lang['justgo']="Go";ipb.lang['loading']="Loading...";ipb.lang['mark_read_forum']="There was a problem fetching this forum.";ipb.lang['mark_read_topic']="There was a problem fetching this topic.";ipb.lang['max_notes_reached']="You cannot add any more notes to this image, because you have reached the maximum number allowed";ipb.lang['member_no_exist']="That member does not exist!";ipb.lang['message_sent']="Your message has been sent";ipb.lang['messenger_cancel']="Cancel";ipb.lang['messenger_edit']="Edit";ipb.lang['missing_data']="Missing data!";ipb.lang['mq_reply_swap']="Reply to #{num} quoted post(s)";ipb.lang['must_enter_name']="You must enter a name";ipb.lang['new_lowercase']="new";ipb.lang['note_confirm_delete']="Are you sure you want to delete this note?";ipb.lang['note_no_permission_a']="You do not have permission to add notes to this image";ipb.lang['note_no_permission_d']="You don't have permission to delete notes";ipb.lang['note_no_permission_e']="You do not have permission to edit this note";ipb.lang['note_save_empty']="Your note cannot be empty; click the Delete link for this note if you do not wish to keep it";ipb.lang['not_available']="&#10007; This name is taken!";ipb.lang['no_more_topics']="No more topics";ipb.lang['no_permission']="You do not have permission for this action";ipb.lang['no_permission_preview']="Sorry, you don't have permission to preview this topic.";ipb.lang['open_tpreview']="Preview this topic";ipb.lang['option_is_empty']="This tag's option cannot be left empty!";ipb.lang['out_of_diskspace']="You have run out of space for uploads";ipb.lang['pass_doesnt_match']="&#10007; The passwords you entered don't match";ipb.lang['pass_too_long']="&#10007; Your password is too long (max. 32 characters)";ipb.lang['pass_too_short']="&#10007; Your password is too short (min. 3 characters)";ipb.lang['pending']="Pending";ipb.lang['photo_editor_cropping_still']="Please finish cropping before clicking 'Done'";ipb.lang['photo_editor_enterurl']="Enter a url here";ipb.lang['poll_not_enough_choices']="One or more of your questions doesn't contain enough choices. Each question must contain at least 2 choices!";ipb.lang['poll_no_more_choices']="You cannot add any more choices to this question";ipb.lang['poll_no_more_q']="You cannot add any more questions to this poll!";ipb.lang['poll_questions_missing']="One or more of your questions doesn't have a valid title";ipb.lang['poll_stats']="You may add [q] more question(s), with [c] choices per question";ipb.lang['post_empty']="Your post is empty";ipb.lang['post_empty_post']="Sorry, you can't submit a blank post. Please enter some text in the editor box";ipb.lang['post_empty_title']="You must enter a topic title!";ipb.lang['post_empty_username']="You must enter a username";ipb.lang['post_hide_reason_default']="Enter a reason...";ipb.lang['post_too_short']="Your post is too short";ipb.lang['prof_comment_empty']="You must enter a comment";ipb.lang['prof_comment_mod']="Your comment was added, but requires approval before it will be displayed";ipb.lang['prof_comment_perm']="You do not have permission to post comments on this profile";ipb.lang['prof_update_button']="Update";ipb.lang['prof_update_default']="What's on your mind?";ipb.lang['quickpm_enter_subject']="Please enter a subject";ipb.lang['quickpm_msg_blank']="Your message is blank";ipb.lang['quote_expand']="<em>Click to view</em>";ipb.lang['quote_on']="on";ipb.lang['quote_said']="said";ipb.lang['quote_title']="Quote";ipb.lang['quote__author']="#name# said";ipb.lang['quote__date_author']="#name#, on #date#, said:";ipb.lang['reached_max_folders']="You have reached the maximum number of allowed folders";ipb.lang['required_data_missing']="Some required data was missing";ipb.lang['rtg_already']="You've already rated this entry";ipb.lang['rtg_awesome']="Awesome!";ipb.lang['rtg_good']="Good";ipb.lang['rtg_nbad']="Not Bad";ipb.lang['rtg_ok']="Okay";ipb.lang['rtg_poor']="Poor";ipb.lang['rtg_topic_locked']="This topic is locked";ipb.lang['save_folder']=">";ipb.lang['saving_post']="Saving post...";ipb.lang['search_default_value']="Search...";ipb.lang['set_as_spammer']="Are you sure you want to flag this user as a spam account?";ipb.lang['signin_badopenid']="Supplied OpenID url is invalid";ipb.lang['signin_nopassword']="No password entered";ipb.lang['signin_nosigninname']="No sign in name entered";ipb.lang['silly_server']="The server returned an error during upload";ipb.lang['spoiler_hide']="Hide";ipb.lang['spoiler_show']="Show";ipb.lang['status_updated']="Your status has been updated";ipb.lang['success']="Success";ipb.lang['switch_to_advanced']="Try our advanced uploader which supports multiple file uploading (modern browser required)";ipb.lang['too_long']="&#10007; The name you entered is too long";ipb.lang['too_short']="&#10007; The name you entered is too short";ipb.lang['topic_polling']="#{count} new replies added. <a href='javascript:void(0);' onclick='#{click}'>Show me</a>";ipb.lang['trouble_uploading']="Trouble uploading?";ipb.lang['unapprove']="Unapprove";ipb.lang['unapproved']="Unapproved";ipb.lang['unhide']="...";ipb.lang['uploading']="Uploading...";ipb.lang['upload_done']="Done (uploaded [total])";ipb.lang['upload_failed']="This upload failed";ipb.lang['upload_limit_hit']="Upload limit exceeded";ipb.lang['upload_no_file']="No file was selected for upload";ipb.lang['upload_progress']="Uploaded [done] of [total]";ipb.lang['upload_queue']="You have attempted to queue too many files. The number of files you can queue is:";ipb.lang['upload_skipped']="Upload Skipped";ipb.lang['upload_too_big']="This file was too big to upload";ipb.lang['usercp_photo_upload']="You have not selected a file to upload";ipb.lang['vote_success']="Vote saved!";ipb.lang['vote_updated']="Vote updated!";ipb.lang['with_selected']="With Selected ({num})";;IPBoard.prototype.hoverCardRegister={mainStore:$H(),initialize:function(key,options)
{var store=$H();if(!ipb.hoverCardRegister.mainStore.get(key))
{ipb.hoverCardRegister.mainStore.set(key,options);}
$$('._hovertrigger').each(function(elem)
{try
{_key=$(elem).readAttribute("hovercard-ref");if(key==_key)
{$(elem).addClassName('___hover___'+key);store.set('key',key);$(elem).removeClassName('_hovertrigger');$(elem).addClassName('_hoversetup');}}
catch(err)
{Debug.error(err);}});store.each(function(elem)
{new ipb.hoverCard('___hover___'+elem.value,options);});},postAjaxInit:function()
{ipb.hoverCardRegister.mainStore.each(function(elem)
{ipb.hoverCardRegister.initialize(elem.key,elem.value);});}};IPBoard.prototype.hoverCard=Class.create({initialize:function(className,options)
{this.id=className;this.timer={},this.card=false,this.ajaxCache={},this.popupActive={},this.openId=false;this.curEvent=false;this.options=Object.extend({type:'balloon',position:'bottomLeft',w:'500px',openOnClick:false,openOnHover:true,ajaxUrl:false,delay:800,ajaxCacheExpire:0,black:false,getId:false,setIdParam:'id',callback:false},arguments[1]);this.init();},init:function()
{this.debugWrite("hoverCard.init()");var _hc=this;document.observe('mousemove',_hc.mMove.bindAsEventListener(_hc));$$('.'+this.id).each(function(elem)
{elem.identify();try
{Event.stopObserving($(elem.id),'mouseout');Event.stopObserving($(elem.id),'mouseover');$(elem.id).writeAttribute('title','');if($(elem.id).down('a'))
{$(elem.id).down('a').writeAttribute('title','');}
if($(elem.id).down('img'))
{$(elem.id).down('img').writeAttribute('title','');$(elem.id).down('img').writeAttribute('alt','');}}
catch(aBall){}
$(elem.id).observe('contextmenu',_hc.mContext.bindAsEventListener(_hc,elem.id));$(elem.id).observe('click',_hc.mClick.bindAsEventListener(_hc,elem.id));$(elem.id).observe('mouseover',_hc.mOver.bindAsEventListener(_hc,elem.id));$(elem.id).observe('mouseout',_hc.mOut.bindAsEventListener(_hc,elem.id));});},mMove:function(e)
{var _newEvent={};for(var i in e){_newEvent[i]=e[i];}
this.curEvent=_newEvent;},mClick:function(e,id)
{if(!this.options.openOnClick)
{this.close(id);}
else
{if($(id).tagName.toLowerCase()=='input'&&$(id).type.toLowerCase()=='checkbox')
{if($(id).checked!==true)
{return true;}}
this.show(id);}},mContext:function(e,id)
{this.close(id);},mOver:function(e,id)
{Event.stop(e);if(this.overPopUp(id)===true)
{return false;}
if(this.options.openOnHover!==true)
{return false;}
this.debugWrite("mover - setting time OVER "+id);if(!Object.isUndefined(this.timer[id+'_out']))
{clearTimeout(this.timer[id+'_out']);}
this.timer[id+'_over']=setTimeout(this.show.bind(this,id),this.options.delay);},mOut:function(e,id)
{Event.stop(e);if(this.overPopUp(id)===true)
{return false;}
Event.stopObserving($(id),'mouseover');$(id).observe('mouseover',this.mOver.bindAsEventListener(this,id));if(!Object.isUndefined(this.timer[id+'_over']))
{clearTimeout(this.timer[id+'_over']);}
this.debugWrite("Mout - setting time OUT "+id);this.timer[id+'_out']=setTimeout(this.close.bind(this,id),800);},show:function(id)
{var popup='pu__'+this.id+'_popup';if(!Object.isUndefined(this.timer[id+'_out']))
{clearTimeout(this.timer[id+'_out']);}
if(!Object.isUndefined(this.card)&&this.card!==false)
{this.card.kill();this.card=false;}
if($(popup))
{$(popup).remove();}
this.openId=id;var content=false;if(this.options.ajaxUrl)
{content="<div class='general_box pad' style='height: 130px; padding-top: 130px; text-align:center'><img src='"+ipb.vars['loading_img']+"' alt='' /></div>";}
else
{if(Object.isFunction(this.options.callback))
{content=this.options.callback(this,id);if(content===false)
{return false;}}
else
{Debug.error("No AJAX or Callback specified. Whaddayagonnado?!");}}
this.card=new ipb.Popup('pu__'+this.id,{type:'balloon',initial:content,stem:true,hideAtStart:false,hideClose:true,defer:false,black:this.options.black,attach:{target:$(id),position:this.options.position},w:this.options.w});Event.stopObserving($(id),'mouseout');Event.stopObserving($(id),'contextmenu');Event.stopObserving($(id),'click');$(id).observe('mouseout',this.mOut.bindAsEventListener(this,id));$(id).observe('contextmenu',this.mContext.bindAsEventListener(this,id));$(id).observe('click',this.mClick.bindAsEventListener(this,id));if(this.options.ajaxUrl)
{this.ajax(id);}},close:function(id)
{if(this.overPopUp(id)===true)
{return false;}
this.debugWrite("Close: "+id);if(!Object.isUndefined(this.timer[id+'_out']))
{this.debugWrite("-- Clearing: "+id+'_out');clearTimeout(this.timer[id+'_out']);}
if(!Object.isUndefined(this.timer[id+'_over']))
{this.debugWrite("-- Clearing: "+id+'_over');clearTimeout(this.timer[id+'_over']);}
if(!Object.isUndefined(this.card)&&this.card!==false&&id==this.openId)
{this.card.hide();this.card=false;this.openId=false;}},ajax:function(id)
{var now=this.unixtime();var url=this.options.ajaxUrl;var bDims={};var aDims={};var popup='pu__'+this.id+'_popup';bDims['height']=$(popup).getHeight();bDims['top']=parseInt($(popup).style.top);if(!Object.isUndefined(this.ajaxCache[id]))
{if(this.options.AjaxCacheExpire)
{if(now-parseInt(this.options.AjaxCacheExpire)<this.ajaxCache[id]['time'])
{this.debugWrite("Fetching from cache "+id);this.card.update(this.ajaxCache[id]['content']);this.card.ready=true;this._rePos(bDims,popup,this.id);return;}}
else
{this.debugWrite("Fetching from cache "+id);this.card.update(this.ajaxCache[id]['content']);this.card.ready=true;this._rePos(bDims,popup,this.id);return;}}
if(this.options.getId)
{var _id=$(id).readAttribute('hovercard-id');url=url+'&'+this.options.setIdParam+'='+_id;}
this.debugWrite("Ajax load "+id+" "+url);new Ajax.Request(url,{method:'get',onSuccess:function(t)
{if(t.responseText!='error')
{if(t.responseText=='nopermission')
{alert(ipb.lang['no_permission']);return;}
if(t.responseText.match("__session__expired__log__out__"))
{this.update('');alert("Your session has expired, please refresh the page and log back in");return false;}
this.debugWrite("AJAX done!");this.card.update(t.responseText);this.card.ready=true;this._rePos(bDims,popup,this.id);this.ajaxCache[id]={'content':t.responseText,'time':now};}
else
{this.debugWrite(t.responseText);return;}}.bind(this)});},_rePos:function(bDims,popup,id)
{aDims={};aDims['height']=$(popup).getHeight();aDims['top']=parseInt($(popup).getStyle('top'));if($('pu__'+id+'_stem').className.match(/top/)&&(aDims['height']!=bDims['height']))
{var _nt=bDims['top']-(aDims['height']-bDims['height'])-10;$(popup).setStyle({'top':_nt+'px'});}},unixtime:function()
{var _time=new Date();return Date.parse(_time)/1000;},overPopUp:function(id)
{var myevent=this.curEvent;if(!id){return;}
try
{if($(Event.findElement(myevent))&&$(Event.findElement(myevent)).descendantOf($('pu__'+this.id+'_popup')))
{this.debugWrite("*** Over Pop Up ***");if(this.openId!==false)
{this.timer[id+'_out']=setTimeout(this.close.bind(this,id),800);}
return true;}}
catch(err){}
return false;},debugWrite:function(text)
{Debug.write(text);}});;var _quickpm=window.IPBoard;_quickpm.prototype.quickpm={popupObj:null,sendingToUser:0,init:function()
{Debug.write("Initializing ips.quickpm.js");document.observe("dom:loaded",function(){ipb.quickpm.initEvents();});},initEvents:function()
{ipb.delegate.register(".pm_button",ipb.quickpm.launchPMform);},launchPMform:function(e,target)
{if(DISABLE_AJAX){return false;}
if(e.ctrlKey==true||e.metaKey==true||e.keyCode==91)
{return false;}
Debug.write("Launching PM form");pmInfo=target.id.match(/pm_([0-9a-z]+)_([0-9]+)/);if(!pmInfo[2]){Debug.error('Could not find member ID in string '+target.id);}
if($('pm_popup_popup'))
{if(pmInfo[2]==ipb.quickpm.sendingToUser)
{try{$('pm_error_'+ipb.quickpm.sendingToUser).hide();}catch(err){}
ipb.quickpm.popupObj.show();Event.stop(e);return;}
else
{ipb.quickpm.popupObj.getObj().remove();ipb.quickpm.sendingToUser=null;ipb.quickpm.sendingToUser=pmInfo[2];}}
else
{ipb.quickpm.sendingToUser=pmInfo[2];}
ipb.quickpm.popupObj=new ipb.Popup('pm_popup',{type:'pane',modal:true,hideAtStart:true,w:'600px'});var popup=ipb.quickpm.popupObj;new Ajax.Request(ipb.vars['base_url']+"&app=members&module=ajax&secure_key="+ipb.vars['secure_hash']+'&section=messenger&do=showQuickForm&toMemberID='+pmInfo[2],{method:'post',evalJSON:'force',onSuccess:function(t)
{if(t.responseJSON&&t.responseJSON['error'])
{switch(t.responseJSON['error'])
{case'noSuchToMember':alert(ipb.lang['member_no_exist']);break;case'cannotUsePMSystem':case'nopermission':alert(ipb.lang['no_permission']);break;default:alert(t.responseJSON['error']);break;}
ipb.quickpm.sendingToUser=0;return;}
else
{popup.update(t.responseText);popup.positionPane();popup.show();if($(popup.getObj()).select('.input_submit')[0]){$(popup.getObj()).select('.input_submit')[0].observe('click',ipb.quickpm.doSend);}
if($(popup.getObj()).select('.use_full')[0]){$(popup.getObj()).select('.use_full')[0].observe('click',ipb.quickpm.useFull);}
if($(popup.getObj()).select('.cancel')[0]){$(popup.getObj()).select('.cancel')[0].observe('click',ipb.quickpm.cancelForm);}}}});Event.stop(e);},cancelForm:function(e)
{$('pm_error_'+ipb.quickpm.sendingToUser).hide();ipb.quickpm.popupObj.hide();Event.stop(e);},useFull:function(e)
{Event.stop(e);var form=new Element('form',{'method':'post','action':ipb.vars['base_url']+'&app=members&module=messaging&section=send&do=form&preview=1&_from=quickPM&fromMemberID='+ipb.quickpm.sendingToUser});var post=new Element('textarea',{'name':'Post'});var subject=new Element('input',{'type':'text','value':$F('pm_subject_'+ipb.quickpm.sendingToUser),'name':'msg_title'});var val=$F('pm_textarea_'+ipb.quickpm.sendingToUser).replace(/<script/ig,'&lt; script').replace(/<\/script/ig,'&lt; /script');val=val.replace(/</g,'&lt;').replace(/>/g,'&gt;');$(form).insert(post).insert(subject).setStyle('position: absolute; left: -500px; top: 0');$(post).update(val);$$('body')[0].insert(form);$(form).submit();},doSend:function(e)
{Debug.write("Sending");if(!ipb.quickpm.sendingToUser){return;}
Event.stop(e);if($F('pm_subject_'+ipb.quickpm.sendingToUser).blank())
{ipb.quickpm.showError(ipb.lang['quickpm_enter_subject']);return;}
if($F('pm_textarea_'+ipb.quickpm.sendingToUser).blank())
{ipb.quickpm.showError(ipb.lang['quickpm_msg_blank']);return;}
var popup=ipb.quickpm.popupObj;if($(popup.getObj()).select('.input_submit')[0]){$(popup.getObj()).select('.input_submit')[0].disabled=true;};new Ajax.Request(ipb.vars['base_url']+'&app=members&module=ajax&secure_key='+ipb.vars['secure_hash']+'&section=messenger&do=PMSend&toMemberID='+ipb.quickpm.sendingToUser,{method:'post',parameters:{'Post':$F('pm_textarea_'+ipb.quickpm.sendingToUser).encodeParam(),'std_used':1,'toMemberID':ipb.quickpm.sendingToUser,'subject':$F('pm_subject_'+ipb.quickpm.sendingToUser).encodeParam()},evalJSON:'force',onSuccess:function(t)
{if(Object.isUndefined(t.responseJSON)){alert(ipb.lang['action_failed']);}
if(t.responseJSON['error'])
{popup.hide();ipb.quickpm.sendingToUser=0;Event.stop(e);switch(t.responseJSON['error'])
{case'cannotUsePMSystem':case'nopermission':alert(ipb.lang['no_permission']);break;default:alert(t.responseJSON['error']);break;}}
else if(t.responseJSON['inlineError'])
{ipb.quickpm.showError(t.responseJSON['inlineError']);if($(popup.getObj()).select('.input_submit')[0]){$(popup.getObj()).select('.input_submit')[0].disabled=false;};return;}
else if(t.responseJSON['status'])
{popup.hide();ipb.quickpm.sendingToUser=0;Event.stop(e);ipb.global.showInlineNotification(ipb.lang['message_sent']);return;}
else
{Debug.dir(t.responseJSON);}}});},showError:function(msg)
{if(!ipb.quickpm.sendingToUser||!$('pm_error_'+ipb.quickpm.sendingToUser)){return;}
$('pm_error_'+ipb.quickpm.sendingToUser).select('.message')[0].update(msg);if(!$('pm_error_'+ipb.quickpm.sendingToUser).visible())
{new Effect.BlindDown($('pm_error_'+ipb.quickpm.sendingToUser),{duration:0.3});}
else
{}
return;}};ipb.quickpm.init();;var _sharelinks=window.IPBoard;_sharelinks.prototype.sharelinks={popups:null,bname:null,url:null,title:null,maxTwitterLen:115,init:function()
{Debug.write("Initializing ips.sharelinks.js");document.observe("dom:loaded",function(){ipb.sharelinks.initEvents();});},initEvents:function()
{ipb.delegate.register('._slink',ipb.sharelinks.sharePop);},sharePop:function(e,elem)
{var shareKey=elem.id.replace(/slink_/,'');var ok=false;var callback=null;var h='190';if(ok===false||DISABLE_AJAX)
{return false;}
Event.stop(e);var _url=ipb.vars['base_url']+'&app=core&module=ajax&secure_key='+ipb.vars['secure_hash']+'&section=sharelinks&do='+shareKey+'Form';var x=new ipb.Popup('shareKeyPop_'+Math.random(),{type:'modal',ajaxURL:_url,modal:true,stem:false,hideAtStart:false,w:'550px',h:h},{'afterAjax':callback,'beforeAjax':ipb.sharelinks.resetPop});},facebookPostPop:function(e,responseText)
{if(responseText=='x')
{window.location="http://www.facebook.com/sharer.php?u="+ipb.sharelinks.url.encodeParam();return false;}
$('fContent').update('');$('fSubmit').observe('click',ipb.sharelinks.goFacebook);},twitterPostPop:function(e,responseText)
{if(responseText=='x')
{window.location="http://twitter.com/intent/tweet?status="+ipb.sharelinks.title.encodeParam()+'%20-%20'+ipb.sharelinks.url.encodeParam();return false;}
ipb.sharelinks.title=ipb.sharelinks.title.replace(/&#34;/g,'"');ipb.sharelinks.title=ipb.sharelinks.title.replace(/&#33;/g,"!");ipb.sharelinks.title=ipb.sharelinks.title.replace(/&#39;/g,"'");ipb.sharelinks.title=ipb.sharelinks.title.replace(/&quot;/g,'"');ipb.sharelinks.bname=ipb.sharelinks.bname.replace(/&#34;/g,'"');ipb.sharelinks.bname=ipb.sharelinks.bname.replace(/&#33;/g,"!");ipb.sharelinks.bname=ipb.sharelinks.bname.replace(/&#39;/g,"'");ipb.sharelinks.bname=ipb.sharelinks.bname.replace(/&quot;/g,'"');Debug.write(ipb.sharelinks.title);$('tContent').value=ipb.sharelinks.bname+': '+ipb.sharelinks.title;$('tContent').observe('keyup',ipb.sharelinks.checkTwitterLength);$('tSubmit').observe('click',ipb.sharelinks.goTwitter);ipb.sharelinks.checkTwitterLength(e);},resetPop:function(e)
{if($('tContent'))
{$('tContent').stopObserving();$('tContent').remove();$('tSubmit').stopObserving();$('tWrap').remove();}
if($('cLeft'))
{$('cLeft').remove();}
if($('fContent'))
{$('fContent').remove();$('fSubmit').stopObserving();$('fWrap').remove();}},goTwitter:function(e)
{if(DISABLE_AJAX)
{return false;}
Event.stop(e);if(!$('tContent')||$F('tContent').blank())
{return;}
new Ajax.Request(ipb.vars['base_url']+'&app=core&module=ajax&secure_key='+ipb.vars['secure_hash']+'&section=sharelinks&do=twitterGo',{method:'post',parameters:{'tweet':$F('tContent').encodeParam(),'title':ipb.sharelinks.title.encodeParam(),'url':ipb.sharelinks.url.encodeParam()},onSuccess:function(t)
{if(t.responseText=='failwhale')
{alert(ipb.lang['action_failed']);return;}
else
{$('tWrap').update(t.responseText);}}});},goFacebook:function(e)
{if(DISABLE_AJAX)
{return false;}
Event.stop(e);new Ajax.Request(ipb.vars['base_url']+'&app=core&module=ajax&secure_key='+ipb.vars['secure_hash']+'&section=sharelinks&do=facebookGo',{method:'post',parameters:{'comment':$F('fContent').encodeParam(),'title':ipb.sharelinks.title.encodeParam(),'url':ipb.sharelinks.url.encodeParam()},onSuccess:function(t)
{if(t.responseText=='finchersaysno')
{alert(ipb.lang['action_failed']);return;}
else
{$('fWrap').update(t.responseText);}}});},checkTwitterLength:function(e)
{newTotal=parseInt(ipb.sharelinks.maxTwitterLen)-parseInt($F('tContent').length);if(newTotal<0)
{$('tContent').value=$F('tContent').truncate(ipb.sharelinks.maxTwitterLen,'');newTotal=0;}
$('cLeft').update(newTotal);}};ipb.sharelinks.init();;var _topic=window.IPBoard;_topic.prototype.topic={totalChecked:0,inSection:'',topic_id:0,page_id:0,postcache:[],poll:[],pollPopups:[],deletePerms:{},deleteUrls:{},deletePopUps:[],hidePopUps:[],restorePopUps:[],counts:{},timers:{},polling:{count:0},mqBoxShowing:false,fastReplyId:'',isPosting:false,modOptionsUnapproved:0,modOptionsHidden:0,modOptionsUnhidden:0,init:function()
{Debug.write("Initializing ips.topic.js");document.observe("dom:loaded",function(){if(ipb.topic.inSection=='topicview')
{if(window.location.hash.substring(1).match(/entry/))
{var pid=window.location.hash.substring(1).replace(/entry/,'');if(ipb.topic.redirectPost&&pid&&$$('a[data-entry-pid]').length&&!$$('a[data-entry-pid="'+pid+'"]').length)
{window.location=ipb.vars['board_url']+'/index.php?app=forums&module=forums&section=findpost&pid='+pid+'&t='+ipb.topic.topic_id;}}
if(!pid)
{pid=getQueryStringParamByName('p');}
if(pid&&$('entry'+pid))
{ipb.topic.scrollToPost(parseInt(pid));}
ipb.delegate.register('a[data-entry-pid]',ipb.topic.launchPostShare);if($('show_filters'))
{$('show_filters').observe('click',ipb.topic.toggleFilters);$('filter_form').hide();}
ipb.topic.preCheckPosts();ipb.delegate.register('.multiquote',ipb.topic.toggleMultimod);ipb.delegate.register('._ips_trigger_quote',ipb.topic.ajaxQuote);ipb.delegate.register('.edit_post',ipb.topic.ajaxEditShow);ipb.delegate.register('.hide_post',ipb.topic.hidePopUp);ipb.delegate.register('.delete_post',ipb.topic.deletePopUp);ipb.delegate.register('.toggle_post',ipb.topic.ajaxTogglePostApprove);ipb.delegate.register('.sd_content',ipb.topic.sDeletePostShow);ipb.delegate.register('.sd_remove',ipb.topic.confirmSingleDelete);ipb.delegate.register('input.post_mod',ipb.topic.checkPost);ipb.delegate.register('.modlink_09',ipb.topic.topicDeletePopUp);if($('submit_post')){$('submit_post').observe("click",ipb.topic.ajaxFastReply);}
try{quoted=ipb.Cookie.get('mqtids').split(',').compact().without('').size();}catch(err){quoted=0;}
if(quoted)
{$('multiQuoteInsert').show();ipb.topic.mqBoxShowing=true;$('mqbutton').update(ipb.lang['mq_reply_swap'].replace(/#{num}/,quoted));}
if($('multiQuoteInsert')){$('mqbutton').observe('click',ipb.topic.insertQuotedPosts);if($('multiQuoteClear')){$('multiQuoteClear').on('click',ipb.topic.clearMultiQuote);}}}
else if(ipb.topic.inSection=='searchview')
{ipb.delegate.register('input.post_mod',ipb.topic.checkPost);ipb.delegate.register('.sd_content',ipb.topic.sDeletePostShow);}});ipb.delegate.register('.hide_signature',ipb.topic.signatureCloseClick);},deleteTopicDialog:function(elem,e)
{if(confirm(ipb.lang['delete_confirm']))
{window.location=ipb.vars['base_url']+"app=forums&module=moderate&section=moderate&do=deleteArchivedTopic&t="+ipb.topic.topic_id+"&f="+ipb.topic.forum_id+"&auth_key="+ipb.vars['secure_hash'];}},restoreTopicDialogGo:function(elem,e)
{Event.stop(e);window.location=ipb.vars['base_url']+"app=forums&module=moderate&section=moderate&do=unArchiveTopic&t="+ipb.topic.topic_id+"&f="+ipb.topic.forum_id+"&auth_key="+ipb.vars['secure_hash'];},restoreTopicDialog:function(elem,e)
{Event.stop(e);var url=ipb.vars['base_url']+"app=core&amp;module=ajax&amp;section=templates&amp;topic_id="+ipb.topic.topic_id+"&secure_key="+ipb.vars['secure_hash']+"&amp;template_group=topic&amp;template_bit=restoreTopicDialog&amp;lang_module=topic&amp;lang_app=forums";new Ajax.Request(url.replace(/&amp;/g,'&'),{method:'post',evalJSON:'force',onSuccess:function(t)
{var popid='pop__restore_popup_'+ipb.topic.topic_id;var content=new Template(t.responseJSON['html']).evaluate({});ipb.topic.restorePopUps=new ipb.Popup(popid,{type:'pane',modal:true,initial:content,hideAtStart:false,w:'550px'});}});},signatureCloseClick:function(e,elem)
{postId=$(elem).up('.post_block').id.replace(/post_id_/,'');Debug.write(postId);if(!postId)
{return;}
Event.stop(e);$(elem).removeClassName('hide_signature').addClassName('sigIconStay');$(elem).identify();$(elem).addClassName('ipbmenu');url=ipb.vars['base_url']+"app=forums&module=ajax&section=topics&do=sigCloseMenu&secure_key="+ipb.vars['secure_hash']+"&pid="+postId;if(ipb.topic.inSection=='messenger')
{url=ipb.vars['base_url']+"app=members&module=ajax&section=messenger&do=sigCloseMenu&secure_key="+ipb.vars['secure_hash']+"&msgid="+postId;}
new Ajax.Request(url,{method:'post',evalJSON:'force',onSuccess:function(t)
{if(t.responseJSON&&t.responseJSON['error'])
{alert(t.responseJSON['error']);}
else
{var menuId='sigClose_'+postId+'_menucontent';$('ipboard_body').insert(new Element('div',{'id':menuId}));$(menuId).update("<div class='ipsPad ipsForm_center'><img src='"+ipb.vars['loading_img']+"' /></div>");var _newMenu=new ipb.Menu($(elem),$(menuId),{},{afterOpen:function(e){Debug.write('adding');$(elem).removeClassName('hide_signature').addClassName('sigIconStay');}});_newMenu.doOpen();ipb.topic.deletePopUps['sig_'+postId]=true;$(menuId).update(t.responseText);ipb.menus.registerCloseCallBack(ipb.topic.signatureCloseCleanUp);}}});},signatureCloseCleanUp:function()
{$$('.sigIconStay').invoke('removeClassName','sigIconStay').invoke('addClassName','hide_signature');},ignoreUsersSig:function(elem,e)
{memberId=$(elem).readAttribute('data-id');ipb.menus.closeAll(e);ipb.topic.signatureCloseCleanUp();new Ajax.Request(ipb.vars['base_url']+"app=forums&module=ajax&section=topics&do=ignoreSig&secure_key="+ipb.vars['secure_hash']+"&memberId="+memberId,{method:'post',evalJSON:'force',onSuccess:function(t)
{if(t.responseJSON&&t.responseJSON['status']=='ok')
{$$(".signature").each(function(element)
{try{_memberId=$(element).readAttribute('data-memberid');if(_memberId&&(memberId=='all'||_memberId==memberId))
{new Effect.BlindUp($(element),{duration:1.0});}}
catch(e){};});}}});},submitPostModeration:function(e)
{if($F('tact')=='delete'){if(!confirm(ipb.lang['delete_confirm'])){Event.stop(e);}}},submitTopicModeration:function(e)
{if($F('topic_moderation')=='03'){if(!confirm(ipb.lang['delete_confirm'])){Event.stop(e);}}},hidePopUp:function(e,elem)
{var postid=elem.up().id.replace(/hide_post_/,'');if(!postid){return;}
var _url_soft=ipb.topic.deleteUrls['softDelete'].evaluate({'pid':postid}).replace(/&amp;/g,'&')+'&nr=1';var _permaShow='';Event.stop(e);var url=ipb.vars['base_url']+"app=core&amp;module=ajax&amp;section=templates&amp;secure_key="+ipb.vars['secure_hash']+"&amp;template_group=topic&amp;template_bit=deletePost&amp;lang_module=topic&amp;lang_app=forums";new Ajax.Request(url.replace(/&amp;/g,'&'),{method:'post',evalJSON:'force',onSuccess:function(t)
{var popid='pop__hide_popup_'+postid;var content=new Template(t.responseJSON['html']).evaluate({removeUrl:_url_soft,permaDelete:_permaShow});ipb.topic.hidePopUps=new ipb.Popup(popid,{type:'balloon',stem:true,modal:false,initial:content,hideAtStart:false,w:'550px',attach:{target:elem,position:'auto','event':'click'}});}});},deletePopUp:function(e,elem)
{var postid=elem.up().id.replace(/del_post_/,'');if(!postid){return;}
var _url_delete=ipb.topic.deleteUrls['hardDelete'].evaluate({'pid':postid}).replace(/&amp;/g,'&')+'&nr=1';var _permaShow='';Event.stop(e);var url=ipb.vars['base_url']+"app=core&amp;module=ajax&amp;section=templates&amp;secure_key="+ipb.vars['secure_hash']+"&amp;template_group=topic&amp;template_bit=doDeletePost&amp;lang_module=topic&amp;lang_app=forums";new Ajax.Request(url.replace(/&amp;/g,'&'),{method:'post',evalJSON:'force',onSuccess:function(t)
{var popid='pop__delete_popup_'+postid;var content=new Template(t.responseJSON['html']).evaluate({permaDelete:_permaShow,permaUrl:_url_delete});ipb.topic.deletePopUps=new ipb.Popup(popid,{type:'balloon',stem:true,modal:false,initial:content,hideAtStart:false,w:'350px',attach:{target:elem,position:'auto','event':'click'}});}});},topicDeletePopUp:function(e,elem)
{var _url_delete='';var _permaShow='';Event.stop(e);var url=ipb.vars['base_url']+"app=core&amp;module=ajax&amp;section=templates&amp;secure_key="+ipb.vars['secure_hash']+"&amp;template_group=forum&amp;template_bit=deleteTopic&amp;lang_module=forums&amp;lang_app=forums";new Ajax.Request(url.replace(/&amp;/g,'&'),{method:'post',evalJSON:'force',onSuccess:function(t)
{var popid='pop__topic_delete_popup';var content=new Template(t.responseJSON['html']).evaluate({deleteUrl:elem.href});new ipb.Popup(popid,{type:'pane',stem:true,modal:true,initial:content,hideAtStart:false,w:'350px'});}});},sDeletePostShow:function(e,elem)
{Event.stop(e);var postid=elem.id.replace(/seeContent_/,'');if(!postid){return;}
if(!$('postsDelete_'+postid)._showing)
{$('postsDelete_'+postid).hide();$('postsDeleteShow_'+postid).show();$('postsDelete_'+postid)._showing=1;}
else
{$('postsDelete_'+postid).show();$('postsDeleteShow_'+postid).hide();$('postsDelete_'+postid)._showing=0;}},launchPostShare:function(e,elem)
{Event.stop(e);var pid=$(elem).readAttribute('data-entry-pid');var url=ipb.vars['base_url']+'app=forums&module=ajax&section=topics&do=postShareModal&p='+pid+'&t='+ipb.topic.topic_id+'&f='+ipb.topic.forum_id+'&md5check='+ipb.vars['secure_hash'];ipb.global.popups['psharer']=new ipb.Popup('psharer',{type:'modal',modal:true,ajaxURL:url,hideAtStart:false,evalJs:'force',w:'550px',h:300});},ajaxTogglePostApprove:function(e,elem)
{Event.stop(e);var postid=elem.id.replace(/toggle(text)?_post_/,'');if(!postid){return;}
var toApprove=($('post_id_'+postid).hasClassName('moderated'))?1:0;var url=ipb.vars['base_url']+'app=forums&module=ajax&section=topics&do=postApproveToggle&p='+postid+'&t='+ipb.topic.topic_id+'&f='+ipb.topic.forum_id+'&approve='+toApprove;new Ajax.Request(url,{method:'post',evalJSON:'force',parameters:{md5check:ipb.vars['secure_hash']},onSuccess:function(t)
{if(t.responseJSON['error'])
{switch(t.responseJSON['error'])
{case'notopic':alert(ipb.lang['no_permission']);break;case'nopermission':alert(ipb.lang['no_permission']);break;}}
else
{$('post_id_'+postid).removeClassName('moderated');$('postControlsUnapproved_'+postid).hide();$('postControlsNormal_'+postid).show();$('checkbox_'+postid).writeAttribute('data-status','0');}}});},ajaxEditShow:function(e,elem)
{if(DISABLE_AJAX||ipb.vars['is_touch'])
{return false;}
if(e.ctrlKey==true||e.metaKey==true||e.keyCode==91)
{return false;}
Event.stop(e);var edit=[];edit['button']=elem;if(!edit['button']){return;}
if(edit['button'].readAttribute('_editing')=='1')
{return false;}
edit['pid']=edit['button'].id.replace('edit_post_','');edit['tid']=ipb.topic.topic_id;edit['fid']=ipb.topic.forum_id;edit['post']=$('post_id_'+edit['pid']).down('.post');ipb.topic.postcache[edit['pid']]=edit['post'].innerHTML;url=ipb.vars['base_url']+'app=forums&module=ajax&section=topics&do=editBoxShow&p='+edit['pid']+'&t='+edit['tid']+'&f='+edit['fid'];if(Prototype.Browser.IE7)
{window.location='#entry'+edit['pid'];}
else
{new Effect.ScrollTo(edit['post'],{offset:-50});}
new Ajax.Request(url,{method:'post',parameters:{md5check:ipb.vars['secure_hash']},onSuccess:function(t)
{if(t.responseText=='nopermission'||t.responseText=='NO_POST_FORUM'||t.responseText=='NO_EDIT_PERMS'||t.responseText=='NO_POSTING_PPD')
{alert(ipb.lang['no_permission']);return;}
if(t.responseText=='error')
{alert(ipb.lang['action_failed']);return;}
edit['button'].writeAttribute('_editing','1');edit['post'].update(t.responseText);edit['pid']='e'+edit['pid'];if($('edit_save_'+edit['pid'])){$('edit_save_'+edit['pid']).observe('click',ipb.topic.ajaxEditSave);}
if($('edit_switch_'+edit['pid'])){$('edit_switch_'+edit['pid']).observe('click',ipb.topic.ajaxEditSwitch);}
if($('edit_cancel_'+edit['pid'])){$('edit_cancel_'+edit['pid']).observe('click',ipb.topic.ajaxEditCancel);}}})
Debug.write(url);},ajaxEditSwitch:function(e)
{Event.stop(e);var elem=Event.element(e);var postid=elem.id.replace('edit_switch_e','');if(!postid){return;}
var url=ipb.vars['base_url']+'app=forums&module=post&section=post&do=edit_post&f='+ipb.topic.forum_id+'&t='+ipb.topic.topic_id+'&p='+postid+'&st='+ipb.topic.start_id+'&_from=quickedit';var Post=ipb.textEditor.getEditor('edit-'+postid).getText();form=new Element('form',{action:url,method:'post'});textarea=new Element('textarea',{name:'Post'});reason=new Element('input',{name:'post_edit_reason'});md5check=new Element('input',{type:'hidden',name:'md5check',value:ipb.vars['secure_hash']});if(Prototype.Browser.Opera){textarea.value=Post;}else{textarea.value=Post;}
reason.value=($('post_edit_reason'))?$('post_edit_reason').value:'';form.insert(md5check).insert(textarea).insert(reason).hide();$$('body')[0].insert(form);form.submit();},ajaxFastReply:function(e)
{if(DISABLE_AJAX)
{return false;}
if(!ipb.vars['member_id'])
{return false;}
if(e.ctrlKey==true||e.metaKey==true||e.keyCode==91)
{return false;}
Event.stop(e);var Post=ipb.textEditor.getEditor(ipb.topic.fastReplyId).getText();var isRte=ipb.textEditor.getEditor(ipb.topic.fastReplyId).isRte();if(Post===false)
{return false;}
if(Post.blank())
{alert(ipb.lang['post_empty']);return false;}
var toggleEditorButtons=function(show){if($('fast_reply_controls')){if(show){$('fast_reply_controls').select("#fast_reply_msg").invoke('remove');$('fast_reply_controls').select("input").invoke("show");}else{$('fast_reply_controls').select("input").invoke("hide");$('fast_reply_controls').insert(new Element('span',{id:'fast_reply_msg'}).update(ipb.lang['saving_post']).addClassName('desc'));}}};toggleEditorButtons(false);ipb.topic.isPosting=true;var elements=new Hash({md5check:ipb.vars['secure_hash'],Post:Post.encodeParam(),isRte:isRte});var formElements=$('ips_fastReplyForm').getElements();for(var i=0,j=formElements.length;i<j;i++)
{if(formElements[i].getAttribute('rel')=='include')
{elements.set(formElements[i].name,formElements[i].getValue());}}
var url=ipb.vars['base_url']+'app=forums&module=ajax&section=topics&do=reply&t='+ipb.topic.topic_id+'&f='+ipb.topic.forum_id+'&pid='+ipb.topic.topPid;Debug.write(url);new Ajax.Request(url,{method:'post',encoding:ipb.vars['charset'],evalJSON:'force',parameters:elements,onSuccess:function(t)
{toggleEditorButtons(true);if(t.responseJSON&&t.responseJSON['error']){if(!Object.isUndefined(ipb.lang[t.responseJSON['error']]))
{ipb.global.errorDialogue(ipb.lang[t.responseJSON['error']]);}
else
{ipb.global.errorDialogue(t.responseJSON['error']);}
return false;}
else if(t.responseJSON&&t.responseJSON['success'])
{if(t.responseJSON['message'])
{ipb.global.okDialogue(t.responseJSON['message']);}
if(t.responseJSON['post']&&t.responseJSON['postid'])
{if(!Object.isUndefined(ipb.topic.counts)&&!Object.isUndefined(ipb.topic.counts['perPage']))
{if((ipb.topic.counts['postTotal'])&&((ipb.topic.counts['postTotal']-ipb.topic.counts['curStart'])>=ipb.topic.counts['perPage']))
{window.location=ipb.vars['base_url']+'showtopic='+ipb.topic.topic_id+'&view=getlastpost';return false;}}
ipb.topic.topPid=t.responseJSON['postid'];if($('newContent-'+ipb.topic.topPid))
{$('newContent-'+ipb.topic.topPid).update(t.responseJSON['post']);}
else if($('post_id_'+ipb.topic.topPid))
{$('post_id_'+ipb.topic.topPid).replace(t.responseJSON['post']);}
else
{$('ips_Posts').insert(new Element('div',{id:'newContent-'+ipb.topic.topPid}).insert(t.responseJSON['post']));}
if($('newContent-'+ipb.topic.topPid))
{$('newContent-'+ipb.topic.topPid).hide();new Effect.BlindDown('newContent-'+ipb.topic.topPid,{duration:0.5,queue:'front'});}
prettyPrint();}
ipb.topic.isPosting=false;var editor=ipb.textEditor.getEditor(ipb.topic.fastReplyId);editor.clearSaveMessage();editor.minimizeOpenedEditor();if(editor.options.isTypingCallBack!==false)
{editor.timers['dirty']=setInterval(editor.checkForInput.bind(editor),ipb.textEditor.IPS_TEXTEDITOR_POLLING);}
return false;}
else if(t.responseText&&t.responseText!='no_permission')
{if(!Object.isUndefined(ipb.topic.counts)&&!Object.isUndefined(ipb.topic.counts['perPage']))
{if((ipb.topic.counts['postTotal'])&&((ipb.topic.counts['postTotal']-ipb.topic.counts['curStart'])>=ipb.topic.counts['perPage']))
{window.location=ipb.vars['base_url']+'showtopic='+ipb.topic.topic_id+'&view=getlastpost';return false;}}
m=t.responseText.match(/<!--post:(\d+?)-->/);if(m&&m[1])
{ipb.topic.topPid=m[1];}
else
{return false;}
$('ips_Posts').insert(new Element('div',{id:'newContent-'+ipb.topic.topPid}).insert(t.responseText));if($('newContent-'+ipb.topic.topPid))
{$('newContent-'+ipb.topic.topPid).hide();new Effect.BlindDown('newContent-'+ipb.topic.topPid,{duration:0.5,queue:'front'});ipb.textEditor.getEditor(ipb.topic.fastReplyId).clearSaveMessage();ipb.textEditor.getEditor(ipb.topic.fastReplyId).minimizeOpenedEditor();prettyPrint();}
ipb.topic.isPosting=false;}}});},ajaxQuote:function(e,elem)
{if(DISABLE_AJAX)
{return false;}
if(e.ctrlKey==true||e.metaKey==true||e.keyCode==91)
{return false;}
Event.stop(e);pid=elem.readAttribute('pid');var url=ipb.vars['base_url']+'app=forums&module=ajax&section=topics&do=quote&t='+ipb.topic.topic_id+'&p='+pid+'&md5check='+ipb.vars['secure_hash']+'&isRte='+ipb.textEditor.getEditor(ipb.topic.fastReplyId).isRte();Debug.write(url);new Ajax.Request(url,{method:'get',encoding:ipb.vars['charset'],onSuccess:function(t)
{if(t.responseJSON&&t.responseJSON['error'])
{if(!Object.isUndefined(ipb.lang[t.responseJSON['error']]))
{ipb.global.errorDialogue(ipb.lang[t.responseJSON['error']]);}
else
{ipb.global.errorDialogue(t.responseJSON['error']);}
return false;}
else if(t.responseText&&t.responseText!='nopermission')
{editor=ipb.textEditor.getEditor(ipb.topic.fastReplyId);editor.insert(ipb.textEditor.convertQuotes(t.responseText),'always');}}});},ajaxEditSave:function(e)
{try{Event.stop(e);var elem=Event.element(e);var postid=elem.id.replace('edit_save_e','');if(!postid){alert("No post ID");return;}
var Post=ipb.textEditor.getEditor('edit-'+postid).getText();if(Post===false)
{return false;}
if(Post.blank())
{alert(ipb.lang['post_empty']);}
var add_edit=null;var edit_reason='';var post_htmlstatus='';if($('add_edit_'+postid)){add_edit=$F('add_edit_'+postid);}
if($('post_edit_reason_'+postid)){edit_reason=$F('post_edit_reason_'+postid);}
if($('post_htmlstatus_'+postid)){post_htmlstatus=$F('post_htmlstatus_'+postid);}
var url=ipb.vars['base_url']+'app=forums&module=ajax&section=topics&do=editBoxSave&p='+postid+'&t='+ipb.topic.topic_id+'&f='+ipb.topic.forum_id;new Ajax.Request(url,{method:'post',evalJSON:'force',encoding:ipb.vars['charset'],parameters:{md5check:ipb.vars['secure_hash'],Post:Post.encodeParam(),add_edit:add_edit,post_edit_reason:edit_reason.encodeParam(),post_htmlstatus:post_htmlstatus},onSuccess:function(t)
{if(t.responseJSON['error'])
{if($('error_msg_e'+postid))
{$('error_msg_e'+postid).update(t.responseJSON['error']);new Effect.BlindDown($('error_msg_e'+postid),{duration:0.4});}
else
{alert(t.responseJSON['error']);}
return false;}
else
{$('edit_post_'+postid).writeAttribute('_editing','0');ipb.textEditor.getEditor('edit-'+postid).remove();$('post_id_'+postid).down('.post').update(t.responseJSON['successString']);prettyPrint();}}});}catch(err){alert(err);}},ajaxEditCancel:function(e)
{Event.stop(e);var elem=Event.element(e);var postid=elem.id.replace('edit_cancel_e','');if(!postid){return;}
if(ipb.topic.postcache[postid])
{ipb.textEditor.getEditor('edit-'+postid).remove();$('post_id_'+postid).down('.post').update(ipb.topic.postcache[postid]);ipb.editors[postid]=null;$('edit_post_'+postid).writeAttribute('_editing','0');}
return;},isTypingCallBack:function()
{if(!Object.isUndefined(ipb.topic.counts)&&!Object.isUndefined(ipb.topic.counts['perPage']))
{if((ipb.topic.counts['postTotal'])&&((ipb.topic.counts['postTotal']-ipb.topic.counts['curStart'])>=ipb.topic.counts['perPage']))
{return false;}}
ipb.topic.pollForReplies();ipb.textEditor.getEditor().timers['interval_hasContent']=setInterval(ipb.topic.pollForReplies,ipb.textEditor.IPS_NEW_POST_POLLING);ipb.topic.timers['_startPolling']=new Date().getTime();Debug.write("Starting timer for reply polling: "+ipb.topic.timers['_startPolling']);},pollForReplies:function()
{var timeNow=new Date().getTime();var timeDiff=(timeNow-ipb.topic.timers['_startPolling'])/1000;Debug.write("I have been polling for : "+timeDiff+" seconds");if(ipb.topic.isPosting===true)
{return;}
if(timeDiff/3600>1)
{Debug.write("I have stopped polling. Sorry.");clearInterval(ipb.textEditor.getEditor().timers['interval_hasContent']);}
else
{var url=ipb.vars['base_url']+'app=forums&module=ajax&section=topics&do=pollForReplies&t='+ipb.topic.topic_id+'&pid='+ipb.topic.topPid+'&md5check='+ipb.vars['secure_hash'];Debug.write(url);new Ajax.Request(url,{method:'get',evalJSON:'force',encoding:ipb.vars['charset'],hideLoader:true,onSuccess:function(t)
{if(t.responseJSON)
{var count=parseInt(t.responseJSON['count']);if(count==ipb.topic.polling.count)
{return false;}
ipb.topic.polling.count=count;if(count)
{string=new Template(ipb.lang['topic_polling']).evaluate({count:count,click:'ipb.topic.insertNewPosts(event)'});ipb.global.showInlineNotification(string,{'showClose':true,'displayForSeconds':20});}}}});}},insertNewPosts:function(e)
{Event.stop(e);ipb.topic.polling.count=0;var url=ipb.vars['base_url']+'app=forums&module=ajax&section=topics&do=getNewPosts&t='+ipb.topic.topic_id+'&pid='+ipb.topic.topPid+'&md5check='+ipb.vars['secure_hash'];Debug.write(url);new Ajax.Request(url,{method:'get',evalJSON:'force',encoding:ipb.vars['charset'],onSuccess:function(t)
{if(t.responseText)
{m=t.responseText.match(/.*<!--post:(\d+?)-->/);if(m&&m[1])
{ipb.topic.topPid=m[1];}
else
{return false;}
$('ips_Posts').insert(new Element('div',{id:'newContent-'+ipb.topic.topPid}).insert(t.responseText));if($('newContent-'+ipb.topic.topPid))
{$('newContent-'+ipb.topic.topPid).hide();new Effect.BlindDown('newContent-'+ipb.topic.topPid,{duration:1.0,queue:'front',afterFinish:function(){$('post_id_'+ipb.topic.topPid).scrollTo()}});prettyPrint();}
ipb.global.closeInlineNotification();}}});return false;},preCheckPosts:function()
{if(!$('selectedpidsJS')||!$F('selectedpidsJS')){return true;}
pids=$F('selectedpidsJS').split(',');if(pids)
{pids.each(function(pid)
{if(!pid.blank())
{if($('checkbox_'+pid))
{ipb.topic.checkPost(this,$('checkbox_'+pid));$('checkbox_'+pid).checked=true;}
else
{ipb.topic.totalChecked++;}}});}
ipb.topic.updatePostModButton();},checkPost:function(e,check)
{Debug.write("Check post");remove=$A();data=$F('selectedpidsJS');if(data!=null){pids=data.split(',')||$A();}else{pids=$A();}
if(check.checked==true)
{pids.push(check.id.replace('checkbox_',''));ipb.topic.totalChecked++;switch(check.readAttribute("data-status"))
{case'1':ipb.topic.modOptionsUnapproved+=1;break;case'2':ipb.topic.modOptionsHidden+=1;break;default:ipb.topic.modOptionsUnhidden+=1;break;}}
else
{remove.push(check.id.replace('checkbox_',''));ipb.topic.totalChecked--;switch(check.readAttribute("data-status"))
{case'1':ipb.topic.modOptionsUnapproved-=1;break;case'2':ipb.topic.modOptionsHidden-=1;break;default:ipb.topic.modOptionsUnhidden-=1;break;}}
pids=pids.uniq().without(remove).join(',');ipb.Cookie.set('modpids',pids,0);$('selectedpidsJS').value=pids;ipb.topic.updatePostModButton();},updatePostModButton:function()
{if(ipb.topic.totalChecked>0)
{if(!$('comment_moderate_box'))
{$$('body')[0].insert({'bottom':ipb.templates['post_moderation'].evaluate({count:ipb.topic.totalChecked})});$('submitModAction').on('click',ipb.topic.doModerate);}
else
{$('comment_count').update(ipb.topic.totalChecked);}
if(!$('comment_moderate_box').visible())
{new Effect.Appear($('comment_moderate_box'),{duration:0.3});}
$('tactInPopup').select('option').invoke('remove');if(ipb.topic.modOptionsUnapproved&&ipb.topic.modPerms['approve'])
{$('tactInPopup').insert(new Element('option',{value:'approve'}).update(ipb.lang['cpt_approve']));}
if(ipb.topic.modOptionsUnhidden&&ipb.topic.modPerms['hide'])
{$('tactInPopup').insert(new Element('option',{value:'delete'}).update(ipb.lang['cpt_hide']));}
if(ipb.topic.modOptionsHidden&&ipb.topic.modPerms['unhide'])
{$('tactInPopup').insert(new Element('option',{value:'sundelete'}).update(ipb.lang['cpt_undelete']));}
if(ipb.topic.modPerms['delete'])
{$('tactInPopup').insert(new Element('option',{value:'deletedo'}).update(ipb.lang['cpt_delete']));}
if(ipb.topic.totalChecked>1&&ipb.topic.modPerms['merge'])
{$('tactInPopup').insert(new Element('option',{value:'merge'}).update(ipb.lang['cpt_merge']));}
if(ipb.topic.modPerms['split'])
{$('tactInPopup').insert(new Element('option',{value:'split'}).update(ipb.lang['cpt_split']));}
if(ipb.topic.modPerms['move'])
{$('tactInPopup').insert(new Element('option',{value:'move'}).update(ipb.lang['cpt_move']));}}
else
{if($('comment_moderate_box'))
{new Effect.Fade($('comment_moderate_box'),{duration:0.3});}}},doModerate:function()
{if(ipb.topic.totalChecked>0)
{$('tact').value=$('tactInPopup').value;if($('tactInPopup').options[$('tactInPopup').selectedIndex].value=='deletedo')
{$('modform').confirmAction();}
else
{$('modform').submit();}}},confirmSingleDelete:function(e,elem)
{if(!confirm(ipb.lang['delete_post_confirm']))
{Event.stop(e);return false;}
return true;},insertQuotedPosts:function(e)
{quoted=ipb.Cookie.get('mqtids');var url=ipb.vars['base_url']+'app=forums&module=ajax&section=topics&do=mqquote&t='+ipb.topic.topic_id;Debug.write(url);new Ajax.Request(url,{method:'post',parameters:{pids:quoted,md5check:ipb.vars['secure_hash']},evalJSON:'force',encoding:ipb.vars['charset'],onSuccess:function(t)
{if(t.responseJSON&&t.responseJSON['error'])
{if(!Object.isUndefined(ipb.lang[t.responseJSON['error']]))
{ipb.global.errorDialogue(ipb.lang[t.responseJSON['error']]);}
else
{ipb.global.errorDialogue(t.responseJSON['error']);}
return false;}
else if(t.responseText&&t.responseText!='nopermission')
{editor=ipb.textEditor.getEditor(ipb.topic.fastReplyId)
editor.insert(ipb.textEditor.convertQuotes(t.responseText),true);}}});$('multiQuoteInsert').hide();ipb.topic.mqBoxShowing=false;$$('.multiquote').each(function(elem){$(elem).removeClassName('selected');});ipb.Cookie.set('mqtids','',0);Event.stop(e);return false;},toggleMultimod:function(e,elem)
{Event.stop(e);try{quoted=ipb.Cookie.get('mqtids').split(',').compact().without('');}catch(err){quoted=$A();}
id=elem.id.replace('multiq_','');quotedItems=0;if(elem.hasClassName('selected'))
{elem.removeClassName('selected');quoted=quoted.uniq().without(id);quotedItems=quoted.size();quoted=quoted.join(',');}
else
{elem.addClassName('selected');quoted.push(id);quotedItems=quoted.size();quoted=quoted.uniq().join(',');}
if(quoted==','){quoted='';}
if(quoted){if(!ipb.topic.mqBoxShowing)
{$('multiQuoteInsert').show();ipb.topic.mqBoxShowing=true;}
$('mqbutton').update(ipb.lang['mq_reply_swap'].replace(/#{num}/,quotedItems));}
else
{if(ipb.topic.mqBoxShowing)
{$('multiQuoteInsert').hide();ipb.topic.mqBoxShowing=false;}}
ipb.Cookie.set('mqtids',quoted,0);},clearMultiQuote:function(e){Event.stop(e);ipb.Cookie.set('mqtids','',0);if($('multiQuoteInsert').visible()){$('multiQuoteInsert').hide();ipb.topic.mqBoxShowing=false;}
$$('.multiquote.selected').invoke('removeClassName','selected');},toggleFilters:function(e)
{if($('filter_form'))
{Effect.toggle($('filter_form'),'blind',{duration:0.2});Effect.toggle($('show_filters'),'blind',{duration:0.2});}},setPostHidden:function(id)
{if($('post_id_'+id).select('.post_wrap')[0])
{$('post_id_'+id).select('.post_wrap')[0].hide();if($('unhide_post_'+id))
{$('unhide_post_'+id).observe('click',ipb.topic.showHiddenPost);}}},showHiddenPost:function(e)
{link=Event.findElement(e,'a');id=link.id.replace('unhide_post_','');if($('post_id_'+id).select('.post_wrap')[0])
{elem=$('post_id_'+id).select('.post_wrap')[0];new Effect.Parallel([new Effect.BlindDown(elem),new Effect.Appear(elem)],{duration:0.5});}
if($('post_id_'+id).select('.post_ignore')[0])
{ignoreElem=$('post_id_'+id).select('.post_ignore')[0];ignoreElem.hide();}
Event.stop(e);},scrollToPost:function(pid)
{if(!pid||!Object.isNumber(pid)){return;}
$('entry'+pid).scrollTo();},showVoters:function(e,qid,cid)
{Event.stop(e);if(!ipb.topic.poll[qid]||!ipb.topic.poll[qid][cid]){return;}
var content=ipb.templates['poll_voters'].evaluate({title:ipb.topic.poll[qid][cid]['name'],content:ipb.topic.poll[qid][cid]['users']});ipb.topic.pollPopups[qid+'_'+cid]=new ipb.Popup('b_voters_'+qid+'_'+cid,{type:'balloon',initial:content,stem:true,hideAtStart:false,attach:{target:$('l_voters_'+qid+'_'+cid),position:'auto','event':'click'},w:'500px'});}};ipb.topic.init();;var _like=window.IPBoard;_like.prototype.like={relid:0,app:'',aprea:'',isfave:0,popped:undefined,wrap:undefined,uc:null,init:function()
{document.observe("dom:loaded",function()
{ipb.delegate.register('.ftoggle',ipb.like.clicked);ipb.delegate.register('._fsubmit',ipb.like.save);ipb.delegate.register('._funset',ipb.like.remove);ipb.delegate.register('._fmore',ipb.like.more);ipb.like.resetEvents();});},resetEvents:function()
{if(ipb.like.wrap){ipb.like.wrap.select("[data-tooltip]").invoke("tooltip");}},clicked:function(e,elem)
{Event.stop(e);relem=elem.up('.__like');relem.identify();ipb.like.wrap=relem;try
{ipb.like.relid=relem.readAttribute('data-relid');ipb.like.app=relem.readAttribute('data-app');ipb.like.area=relem.readAttribute('data-area');ipb.like.isfave=relem.readAttribute('data-isfave');}
catch(e)
{Debug.error(e);}
if(ipb.like.relid&&ipb.like.app&&ipb.like.area)
{if(parseInt(ipb.like.isfave)==1)
{ipb.like.dialogueUnset(e,elem);}
else
{ipb.like.dialogueSet(e,elem);}}},more:function(e,elem)
{Event.stop(e);relem=elem.up('.__like');relem.identify();ipb.like.wrap=relem;try
{ipb.like.relid=relem.readAttribute('data-relid');ipb.like.app=relem.readAttribute('data-app');ipb.like.area=relem.readAttribute('data-area');ipb.like.isfave=relem.readAttribute('data-isfave');}
catch(e)
{Debug.error(e);}
if(!Object.isUndefined(ipb.like.popped))
{ipb.like.popped.kill();}
var popid='setfave_'+ipb.like.relid;var _url=ipb.vars['base_url']+'&app=core&module=ajax&section=like&do=more&secure_key='+ipb.vars['secure_hash']+'&f_app='+ipb.like.app+'&f_area='+ipb.like.area+'&f_relid='+ipb.like.relid;Debug.write(_url);ipb.like.popped=new ipb.Popup(popid,{type:'balloon',ajaxURL:_url,stem:true,hideAtStart:false,hideClose:true,attach:{target:elem,position:'auto'},h:200,w:'250px'});},dialogueUnset:function(e,elem)
{Event.stop(e);if(!Object.isUndefined(ipb.like.popped))
{ipb.like.popped.kill();}
var popid='setfave_'+ipb.like.relid;var _content=FAVE_TEMPLATE.evaluate();ipb.like.popped=new ipb.Popup(popid,{type:'balloon',initial:_content,stem:true,hideAtStart:false,attach:{target:elem,position:'auto'},w:'350px'});},dialogueSet:function(e,elem)
{Event.stop(e);if(!Object.isUndefined(ipb.like.popped))
{ipb.like.popped.kill();}
var popid='setfave_'+ipb.like.relid;var _url=ipb.vars['base_url']+'&app=core&module=ajax&section=like&do=setDialogue&secure_key='+ipb.vars['secure_hash']+'&f_app='+ipb.like.app+'&f_area='+ipb.like.area+'&f_relid='+ipb.like.relid;Debug.write(_url);ipb.like.popped=new ipb.Popup(popid,{type:'balloon',ajaxURL:_url,stem:true,hideAtStart:false,attach:{target:elem,position:'auto'},w:'350px'});},save:function(e,elem)
{Event.stop(e);var like_notify=$('like_notify').checked?1:0;var like_freq=$F('like_freq');var like_anon=$('like_anon').checked?1:0;ipb.like.popped.hide();ipb.like.wrap.writeAttribute('data-isfave',1);ipb.like.isfave=1;var _url=ipb.vars['base_url']+'&app=core&module=ajax&section=like&do=save&secure_key='+ipb.vars['secure_hash']+'&f_app='+ipb.like.app+'&f_area='+ipb.like.area+'&f_relid='+ipb.like.relid;Debug.write(_url);new Ajax.Request(_url,{method:'post',parameters:{'like_notify':like_notify,'like_freq':like_freq,'like_anon':like_anon},onSuccess:function(t)
{if(t.responseText=='nopermission')
{alert(ipb.lang['no_permission']);}
else
{ipb.like.wrap.update(t.responseText);ipb.like.resetEvents();}}});},remove:function(e,elem)
{Event.stop(e);ipb.like.popped.hide();ipb.like.wrap.writeAttribute('data-isfave',0);ipb.like.isfave=0;var _url=ipb.vars['base_url']+'&app=core&module=ajax&section=like&do=unset&secure_key='+ipb.vars['secure_hash']+'&f_app='+ipb.like.app+'&f_area='+ipb.like.area+'&f_relid='+ipb.like.relid;Debug.write(_url);new Ajax.Request(_url,{method:'get',hideLoader:true,onSuccess:function(t)
{if(t.responseText=='nopermission')
{alert(ipb.lang['no_permission']);}
else
{ipb.like.wrap.update(t.responseText);ipb.like.resetEvents();}}});}};ipb.like.init();