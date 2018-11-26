	$.fbuilder.controls[ 'fapp' ] = function(){};
	$.extend( 
		$.fbuilder.controls[ 'fapp' ].prototype, 
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			title:"Number",
			ftype:"fapp",			
			services:new Array({name:"Service 1",price:1,duration:60}),
			openhours:new Array({type:"all",d:"",h1:8,m1:0,h2:17,m2:0}),
			usedSlots:new Array(),
			dateFormat:"mm/dd/yy",
			showDropdown:false,
			showTotalCost:false,
			showTotalCostFormat:"$ {0}",
			showEndTime:false,
			dropdownRange:"-10:+10",
			working_dates:[true,true,true,true,true,true,true],
			numberOfMonths:1,
			maxNumberOfApp:0,
			firstDay:0,
			minDate:"0",
			maxDate:"",
			defaultDate:"",
			invalidDates:"",
			required:true,			
			bSlotsCheckbox: true,
			bSlots:30,
			militaryTime:1,
			cacheArr:new Array(),
			getD:new Date(),
			formId:0,
			show:function()
				{
					return '<div class="fields '+this.csslayout+'" id="field'+this.form_identifier+'-'+this.index+'"><label for="'+this.name+'">'+this.title+''+((this.required)?"<span class='r'>*</span>":"")+'</label><div class="dfield"><input class="field '+((this.required)?" required":"")+'" id="'+this.name+'" name="'+this.name+'" type="hidden" value=""/><input class="" id="tcost'+this.name+'" name="tcost'+this.name+'" type="hidden" value=""/><div class="fieldCalendarService'+this.name+'"></div><div class="fieldCalendar'+this.name+'"></div><div class="slotsCalendar'+this.name+'"></div><div class="usedSlots'+this.name+'"></div><span class="uh">'+this.userhelp+'</span></div><div class="clearer"></div></div>';
				},
			after_show:function()
				{
					  function onChangeDateOrService(d)
			  	  {
			  	  	  function formattime(t,mt)//mt=2 for database 09:00
								{
									  var h = Math.floor(t/60);
								    var m = t%60;
								    var suffix = "";
								    if (mt==0)
								    {
								        if (h>12)
								        {
								            h = h-12;
								            suffix = " PM";
								        }
								        else
								            suffix = " AM";    
								    }
									  return (((h<10)?((mt==2)?"0":""):"")+h+":"+(m<10?"0":"")+m)+suffix;									
								}
								function loadSlots(d)
								{
									  var duration = $(".fieldCalendarService"+me.name+" select option:selected").val()*1;
									  var bduration = duration;
									  arr = new Array();
									  if (!me.bSlotsCheckbox)
								        bduration = me.bSlots*1;
								    if (me.cacheOpenHours[d])
								        arr = me.cacheOpenHours[d];
								    else if (me.cacheOpenHours["d"+$.datepicker.parseDate("yy-mm-dd", d).getDay()])
								    	  arr = me.cacheOpenHours["d"+$.datepicker.parseDate("yy-mm-dd", d).getDay()];
								    else if (me.cacheOpenHours["all"])
								    	  arr = me.cacheOpenHours["all"];
								    //if (!me.cacheArr[d])	
								    if (me.formId == 0)
								    {  	
								    	  me.formId = $(".fieldCalendarService"+me.name).parents("form").find('input[type="hidden"][name$="_id"]').val();
									      $.ajax(
						      	    {
						      	    	dataType : 'json',
						      	    	type: "POST",
						      	    	url : document.location.href,
						      	    	cache : true,
						      	    	data :  { cp_app_action: 'get_slots',
						      	    		formid: me.formId,
						      	    		formfield: me.name.replace(me.form_identifier, "")   
						      	    		},
						      	    	  success : function( data ){
						      	    	  for (var i=0;i<data.length;i++)
						      	    	  {
						      	    	      var dd = data[i].d;
						      	    	      me.cacheArr[dd] = me.cacheArr[dd] || [];
						      	    	      me.cacheArr[dd][me.cacheArr[dd].length] = data[i];	
						      	    	  }
						      	    		me.cacheArr[d] = me.cacheArr[d] || [];
						      	    		getSlots(arr,duration,bduration,d,me.cacheArr[d]);					      			
						      	    	}
						      	    });	
						        }
						        else
						        {	
						        	  me.cacheArr[d] = me.cacheArr[d] || [];
						            getSlots(arr,duration,bduration,d,me.cacheArr[d]);
						        }    
								}
								function getSlots(arr,duration,bduration,d,data1)
								{ 									     
									      var str = "";								
						            for (var i=0;i<arr.length;i++)
						      			{
						      				  arr[i].t1 = arr[i].h1 * 60 + arr[i].m1*1;
						      				  arr[i].t2 = arr[i].h2 * 60 + arr[i].m2*1;
						      			}
						      			//alert(d);
						      			me.usedSlots[d] = me.usedSlots[d] || [];
						      			data = $.merge(data1.slice(0),me.usedSlots[d]);
						      			for (var i=0;i<data.length;i++)
						      			{
						      				  data[i].t1 = data[i].h1 * 60 + data[i].m1*1;
						      				  data[i].t2 = data[i].h2 * 60 + data[i].m2*1;
						      				  
						      				  for (var j=0;j<arr.length;j++)
						      				  {
						      				  	  if ((data[i].t1 > arr[j].t1) && (data[i].t1 < arr[j].t2)   &&  (data[i].t2 > arr[j].t1) && (data[i].t2 < arr[j].t2))
						      				  	  {
						      				  	  	  var v1 = {t1:arr[j].t1,  t2:data[i].t1,   h1:arr[j].h1,  h2:data[i].h1,   m1:arr[j].m1,  m2:data[i].m1};
						      				  	  	  var v2 = {t1:data[i].t2, t2:arr[j].t2,    h1:data[i].h2, h2:arr[j].h2,    m1:data[i].m2, m2:arr[j].m2};
						      				  	      arr.splice(j, 1, v1, v2);
						      				  	  }
						      				  	  else if ((data[i].t1 > arr[j].t1) && (data[i].t1 < arr[j].t2))
						      				  	  {
						      				  	  	  arr[j].t2 = data[i].t1;
						      				  	  	  arr[j].h2 = data[i].h1;
						      				  	  	  arr[j].m2 = data[i].m1;
						      				  	  } 
						      				  	  else if ((data[i].t2 > arr[j].t1) && (data[i].t2 < arr[j].t2))
						      				  	  {
						      				  	  	  arr[j].t1 = data[i].t2;
						      				  	  	  arr[j].h1 = data[i].h2;
						      				  	  	  arr[j].m1 = data[i].m2;
						      				  	  }
						      				  	  else if ((data[i].t1 <= arr[j].t1) && (data[i].t2 >= arr[j].t2))
						      				  	  {
						      				  	  	  arr.splice(j, 1);
						      				  	  }
						      				  }
						      			}
						      			for (var i=0;i<arr.length;i++)
									      {
									      	
									      	st = arr[i].h1*60+arr[i].m1*1;
									      	et = arr[i].h2*60+arr[i].m2*1;
									      	while (st+duration<=et)
									      	{
									      	    str+= "<div><a href=\"\" h1=\""+Math.floor((st)/60)+"\" m1=\""+((st)%60)+"\" h2=\""+Math.floor((st+duration)/60)+"\" m2=\""+((st+duration)%60)+"\">"+formattime(st,me.militaryTime)+(me.showEndTime?("-"+formattime(st+duration,me.militaryTime)):"")+"</a></div>";
									      	    st += bduration;
									      	}
								        }
								        $( '#field' + me.form_identifier + '-' + me.index + ' .slotsCalendar'+me.name ).html("<div class=\"slots\">"+$.datepicker.formatDate(me.dateFormat, $.datepicker.parseDate("yy-mm-dd", d))+"<br />"+str+"</div>");
								        var str1="",str2="";
								        me.allUsedSlots = me.allUsedSlots || [];
								        j = 0;
								        var total = 0;
								        for (var i=0;i<me.allUsedSlots.length;i++)
								        {
								        	  total += me.allUsedSlots[i].price;
								        	  str1 += "<div class=\"ahb_list\"><span class=\"ahb_list_time\">"+$.datepicker.formatDate(me.dateFormat, $.datepicker.parseDate("yy-mm-dd", me.allUsedSlots[i].d))+" "+formattime(me.allUsedSlots[i].h1*60+me.allUsedSlots[i].m1*1,me.militaryTime)+(me.showEndTime?("-"+formattime(me.allUsedSlots[i].h2*60+me.allUsedSlots[i].m2*1,me.militaryTime)):"")+"</span><span class=\"ahb_list_service\">"+me.services[me.allUsedSlots[i].serviceindex].name+"</span><a href=\"\" i=\""+j+"\" iall=\""+i+"\">["+(cp_hourbk_cancel_label?cp_hourbk_cancel_label:'cancel')+"]</a></div>";
								        	  str2 += ((str2=="")?"":";")+me.allUsedSlots[i].d+" "+formattime(me.allUsedSlots[i].h1*60+me.allUsedSlots[i].m1*1,2)+"/"+formattime(me.allUsedSlots[i].h2*60+me.allUsedSlots[i].m2*1,2)+" "+me.allUsedSlots[i].serviceindex;
								        	  if (me.allUsedSlots[i].d==d)
								        	    j++;
								        }
								        if (me.showTotalCost && (str1!=""))
								            str1 += '<div class="totalCost"><span>'+cp_hourbk_cost_label+'</span> '+me.showTotalCostFormat.replace("{0}", total)+'</div>';
								        $( '#field' + me.form_identifier + '-' + me.index + ' .usedSlots'+me.name ).html(str1);	
								        $( '#field' + me.form_identifier + '-' + me.index + ' #'+me.name ).val(str2);
								        $( '#field' + me.form_identifier + '-' + me.index + ' #tcost'+me.name ).val(total);
								        
								        $( '#field' + me.form_identifier + '-' + me.index + ' .slots a').on("click", function() 
						            {	
						            	me.allUsedSlots = me.allUsedSlots || [];
						            	if (me.maxNumberOfApp==0 || me.allUsedSlots.length<me.maxNumberOfApp)
						            	{	
						            	    me.usedSlots[d] = me.usedSlots[d] || [];			
						            	    
						            	    obj = {h1:$(this).attr("h1")*1,m1:$(this).attr("m1")*1,h2:$(this).attr("h2")*1,m2:$(this).attr("m2")*1,d:d,serviceindex:$(".fieldCalendarService"+me.name+" select option:selected").index(),price:parseFloat(me.services[$(".fieldCalendarService"+me.name+" select option:selected").index()].price)};	            	
						            	    me.usedSlots[d][me.usedSlots[d].length] = obj; 
						            	    me.allUsedSlots[me.allUsedSlots.length] = obj;
						            	    onChangeDateOrService($.datepicker.formatDate('yy-mm-dd', me.getD));
						              }
						              else
						                  alert($.validator.messages.maxapp.replace("{0}",me.maxNumberOfApp));
						            	return false;
						            });
						            
						            $( '#field' + me.form_identifier + '-' + me.index + ' .usedSlots'+me.name+ ' a').on("click", function() 
						            {
						            	me.usedSlots[d] = me.usedSlots[d] || [];
						            	me.usedSlots[d].splice($(this).attr("i")*1, 1);
						            	me.allUsedSlots.splice($(this).attr("iall")*1, 1);
						            	onChangeDateOrService($.datepicker.formatDate('yy-mm-dd', me.getD)); 
						            	return false;
						            });
						                
									
								}
								var arr = new Array();
								for (var i=0;i<me.openhours.length;i++)
								{
									if (me.openhours[i].type=="special")
								  {
								  	  arr[me.openhours[i].d] = arr[me.openhours[i].d] || [];
								  	  arr[me.openhours[i].d][arr[me.openhours[i].d].length] = jQuery.extend({}, me.openhours[i]);
								  }
								  else
								  {
								      arr[me.openhours[i].type] = arr[me.openhours[i].type] || [];
								      arr[me.openhours[i].type][arr[me.openhours[i].type].length] = jQuery.extend({}, me.openhours[i]);	
								  }        
								}
								me.cacheOpenHours = arr;
								loadSlots(d);	  
								
			  	  }
					var me  = this,
						e   = $( '#field' + me.form_identifier + '-' + me.index + ' .fieldCalendar'+me.name ),
						d   = $( '#field' + me.form_identifier + '-' + me.index + ' .fieldCalendarService'+me.name ),
						str = "",
						op = "";
						this.invalidDates = this.invalidDates.replace( /\s+/g, '' );
					  if( !/^\s*$/.test( this.invalidDates ) )
					  {
					  	  var	dateRegExp = new RegExp( /^\d{1,2}\/\d{1,2}\/\d{4}$/ ),
					  	      counter = 0,
					  	      dates = this.invalidDates.split( ',' );
					  	  this.invalidDates = [];
					  	  for( var i = 0, h = dates.length; i < h; i++ )
					  	  {
					  	  	  var range = dates[ i ].split( '-' );
                    
					  	  	  if( range.length == 2 && range[0].match( dateRegExp ) != null && range[1].match( dateRegExp ) != null )
					  	  	  {
					  	  	  	  var fromD = new Date( range[ 0 ] ),
					  	  	  	  	  toD = new Date( range[ 1 ] );
					  	  	  	  while( fromD <= toD )
					  	  	  	  {
					  	  	  	  	  this.invalidDates[ counter ] = fromD;
					  	  	  	  	  var tmp = new Date( fromD.valueOf() );
					  	  	  	  	  tmp.setDate( tmp.getDate() + 1 );
					  	  	  	  	  fromD = tmp;
					  	  	  	  	  counter++;
					  	  	  	  }
					  	  	  }
					  	  	  else
					  	  	  {
					  	  	  	  for( var j = 0, k = range.length; j < k; j++ )
					  	  	  	  {
					  	  	  	  	  if( range[ j ].match( dateRegExp ) != null )
					  	  	  	  	  {
					  	  	  	  	  	  this.invalidDates[ counter ] = new Date( range[ j ] );
					  	  	  	  	  	  counter++;
					  	  	  	  	  }
					  	  	  	  }
					  	  	  }
					  	  }
					  }
						if ($.validator.messages.date_format!="")	
						    me.dateFormat = $.validator.messages.date_format;
						for (var i=0;i<me.services.length;i++)
						    str += '<option value="'+me.services[i].duration+'">'+me.services[i].name+'</option>';
						d.html('<select>'+str+'</select>');
						$(".fieldCalendarService"+me.name+" select").bind("change", function() 
						{
							 onChangeDateOrService($.datepicker.formatDate('yy-mm-dd', me.getD));
						});
						e.datepicker({numberOfMonths:parseInt(me.numberOfMonths),
							firstDay:parseInt(me.firstDay),
							minDate:me.minDate,
							maxDate:me.maxDate,
							dateFormat:me.dateFormat,
							defaultDate:me.defaultDate,
							changeMonth: me.showDropdown, 
							changeYear: me.showDropdown,
							yearRange: ((me.showDropdown)?me.dropdownRange:""),
							onSelect: function(d,inst) {
								me.getD = e.datepicker("getDate");
								onChangeDateOrService($.datepicker.formatDate("yy-mm-dd", me.getD));
								
             	},
							beforeShowDay: function (d) {
								    var day = $.datepicker.formatDate('yy-mm-dd', d);
                    var c =  new Array(day);
                    if (me.working_dates[d.getDay()]==0)
                        c.push("nonworking  ui-datepicker-unselectable ui-state-disabled");
                    for( var i = 0, l = me.invalidDates.length; i < l; i++ )
                    {
                    	if (d.getTime() === me.invalidDates[i].getTime())
                    	    c.push("nonworking  ui-datepicker-unselectable ui-state-disabled invalidDate");
                    }    
                    return [true,c.join(" ")];
		          }
		        });
		        e.datepicker("option", $.datepicker.regional[$.validator.messages.language]);
		        e.datepicker("option", "firstDay", me.firstDay );
		        e.datepicker("option", "dateFormat", me.dateFormat );
		        e.datepicker("option", "minDate", me.minDate );
		        e.datepicker("option", "maxDate", me.maxDate );
		        
		        me.tmpinvalidDatestime = new Array();
            try {
                  for (var i=0;i<me.tmpinvalidDates.length;i++)
                      me.tmpinvalidDatestime[i]=me.invalidDates[i].getTime();              
            } catch (e) {}
            function DisableSpecificDates(date) {
                var currentdate = date.getTime();
                if ($.inArray(currentdate, me.tmpinvalidDatestime) > -1 ) 
                    return false;
                if (me.working_dates[date.getDay()]==0)
                    return false; 
                return true;
            }
            var sum = 0;
            for (var i=0;i<me.working_dates.length;i++)
                sum += me.working_dates[i];
            if (sum>0)
            {       
		           var nextdateAvailable = e.datepicker("getDate");
               while (!DisableSpecificDates(nextdateAvailable))
                   nextdateAvailable.setDate(nextdateAvailable.getDate() + 1);
               e.datepicker("setDate", nextdateAvailable);  
               me.getD = nextdateAvailable;  
		           onChangeDateOrService($.datepicker.formatDate('yy-mm-dd', nextdateAvailable));
		        }
				},
			val:function()
				{
					return 0;
				}		
		}
	);