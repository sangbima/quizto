 
function remove_entry(redir_cont){
	
	if(confirm("Do you really want to remove entry?")){
		window.location=base_url+"index.php/"+redir_cont;
	}
	
}



function updategroup(vall,gid){
	 
	var formData = {group_name:vall};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/user/update_group/"+gid,
		success: function(data){
		$("#message").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}

function updategroupprice(vall,gid){
	 
	var formData = {price:vall};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/user/update_group/"+gid,
		success: function(data){
		$("#message").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}


function updategroupvalid(vall,gid){
	 
	var formData = {valid_day:vall};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/user/update_group/"+gid,
		success: function(data){
		$("#message").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}



function updatecategory(vall,cid){
	 
	var formData = {category_name:vall};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/qbank/update_category/"+cid,
		success: function(data){
		$("#message").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}



function getexpiry(){
	 var gid=document.getElementById('gid').value;
	var formData = {gid:gid};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/user/get_expiry/"+gid,
		success: function(data){
		$("#subscription_expired").val(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}


function updatelevel(vall,lid){
	 
	var formData = {level_name:vall};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/qbank/update_level/"+lid,
		success: function(data){
		$("#message").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}



function hidenop(vall){
	if(vall == '1' || vall=='2' || vall=='3'){
		$("#nop").css('display','block');
	}else{
	$("#nop").css('display','none');
	}
}



function addquestion(quid,qid){
	 var did='#q'+qid;
	var formData = {quid:quid};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/quiz/add_qid/"+quid+'/'+qid,
		success: function(data){
		$(did).html(document.getElementById('added').value);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}





 
var position_type="Up";
var global_quid="0";
var global_qid="0";
var global_opos="0";

function cancelmove(position_t,quid,qid,opos){
	save_answer(qn);
	position_type=position_t;
	global_quid=quid;
	global_qid=qid;
	global_opos=opos;

	if((document.getElementById('warning_div').style.display)=="block"){
		document.getElementById('warning_div').style.display="none";
	}else{
		document.getElementById('warning_div').style.display="block";
		if(position_type=="Up"){
			var upos=parseInt(global_opos)-parseInt(1);
		}else{
			var upos=parseInt(global_opos)+parseInt(1);
		}
		document.getElementById('qposition').value=upos;
	}
}

function cancelmovedisc(position_t,quid,qid,opos){
	save_answer_disc(qn);
	position_type=position_t;
	global_quid=quid;
	global_qid=qid;
	global_opos=opos;

	if((document.getElementById('warning_div').style.display)=="block"){
		document.getElementById('warning_div').style.display="none";
	}else{
		document.getElementById('warning_div').style.display="block";
		if(position_type=="Up"){
			var upos=parseInt(global_opos)-parseInt(1);
		}else{
			var upos=parseInt(global_opos)+parseInt(1);
		}
		document.getElementById('qposition').value=upos;
	}
}


function movequestion(){

var pos=document.getElementById('qposition').value;

if(position_type=="Up"){
var npos=parseInt(global_opos)-parseInt(pos);
window.location=base_url+"index.php/quiz/up_question/"+global_quid+"/"+global_qid+"/"+npos;
}else{
var npos=parseInt(pos)-parseInt(global_opos);
window.location=base_url+"index.php/quiz/down_question/"+global_quid+"/"+global_qid+"/"+npos;
}
}



function no_q_available(lid){
	var cid=document.getElementById('cid').value;
	
		var formData = {cid:cid};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/quiz/no_q_available/"+cid+'/'+lid,
		success: function(data){
		$('#no_q_available').html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
}




// quiz attempt functions 

var noq=0;
var qn=0;
var lqn=0;

function fide_all_question(){
	
	for(var i=0; i < noq; i++){
		
		var did="#q"+i;
	$(did).css('display','none');
	}
}


function show_question(vqn){
	change_color(vqn);
	fide_all_question();
	var did="#q"+vqn;
	$(did).css('display','block');
	// hide show next back btn
	if(vqn >= 1){
	$('#backbtn').css('visibility','visible');
	}
	
	if(vqn < noq){
	$('#nextbtn').css('visibility','visible');
	}
	if((parseInt(vqn)+1) == noq){
	  
	$('#nextbtn').css('visibility','hidden');
	}
	if(vqn == 0){
	$('#backbtn').css('visibility','hidden');
	}
	
	// last qn
	qn=vqn;
lqn=vqn;
setIndividual_time(lqn);
save_answer(lqn);
	
}

function show_next_question(){

	if((parseInt(qn)+1) < noq){
		fide_all_question();
		qn=(parseInt(qn)+1);
		var did="#q"+qn;
		$(did).css('display','block');
	}
	// hide show next back btn
	if(qn >= 1){
		$('#backbtn').css('visibility','visible');
	}
	if((parseInt(qn)+1) == noq){
		$('#nextbtn').css('visibility','hidden');
	}
	change_color(lqn);
	setIndividual_time(lqn);
	save_answer(lqn);
	
	// last qn
	lqn=qn;	
		
}

function show_next_question_ist(){

	if((parseInt(qn)+1) < noq){
	fide_all_question();
	qn=(parseInt(qn)+1);
	var did="#q"+qn;
	$(did).css('display','block');
	}
	// hide show next back btn
	if(qn >= 1){
	$('#backbtn').css('visibility','visible');
	}
	if((parseInt(qn)+1) == noq){
	$('#nextbtn').css('visibility','hidden');
	}
	change_color(lqn);
	setIndividual_time(lqn);
	save_answer_ist(lqn);
	
	// last qn
	lqn=qn;	
		
}
function show_back_question(){
	
	if((parseInt(qn)-1) >= 0 ){
	fide_all_question();
	qn=(parseInt(qn)-1);
	var did="#q"+qn;
	$(did).css('display','block');
	}
	// hide show next back btn
	if(qn < noq){
	$('#nextbtn').css('visibility','visible');
	}
	if(qn == 0){
	$('#backbtn').css('visibility','hidden');
	}
	change_color(lqn);
	setIndividual_time(lqn);
	save_answer(lqn);
	
	// last qn
	lqn=qn;	
		
}


function change_color(qn){
	var did='#qbtn'+qn;
	var q_type='#q_type'+lqn;
	
	// if not answered then make red
	// alert($(did).css('backgroundColor'));
	if($(did).css('backgroundColor') != 'rgb(68, 157, 68)' && $(did).css('backgroundColor') != 'rgb(236, 151, 31)'){
	$(did).css('backgroundColor','#c9302c');
	$(did).css('color','#ffffff');
	}
	
	// answered make green
	if(lqn >= '0' && $(did).css('backgroundColor') != 'rgb(236, 151, 31)'){
	var ldid='#qbtn'+lqn;
		
		if($(q_type).val()=='1' || $(q_type).val()=='2'){
		var green=0;
		for(var k=0; k<=10; k++){
			var answer_value="answer_value"+lqn+'-'+k;
			if(document.getElementById(answer_value)){
				if(document.getElementById(answer_value).checked == true){	
				green=1;
				}
			}
		}
		if(green==1){			
		$(ldid).css('backgroundColor','#449d44');
		$(ldid).css('color','#ffffff');	
		}		
		}		
 		
		if($(q_type).val()=='3' || $(q_type).val()=='4'){
		var answer_value="#answer_value"+lqn;
		if($(answer_value).val()!=''){			
		$(ldid).css('backgroundColor','#449d44');
		$(ldid).css('color','#ffffff');	
		}
		}		
 		
		if($(q_type).val()=='5'){
			var green=0;
			for(var k=0; k<=10; k++){
				var answer_value="answer_value"+lqn+'-'+k;
				if(document.getElementById(answer_value)){
					if(document.getElementById(answer_value).value != '0'){	
					green=1;
					}
				}
			}
			if(green==1){			
			$(ldid).css('backgroundColor','#449d44');
			$(ldid).css('color','#ffffff');	
			}		
		}		
		
	}
	
}


// clear radio btn response
function clear_response(){
var q_type='#q_type'+qn;
		
		if($(q_type).val()=='1' || $(q_type).val()=='2'){
		 
		for(var k=0; k<=10; k++){
			var answer_value="answer_value"+lqn+'-'+k;
			
			if(document.getElementById(answer_value)){
				
				if(document.getElementById(answer_value).checked == true){
					
				document.getElementById(answer_value).checked=false;
				}
			}
		}
	 		
		}	
		
		if($(q_type).val()=='3' || $(q_type).val()=='4'){
		var answer_value="answer_value"+qn;
		document.getElementById(answer_value).value='';
		}	
		
		
		
		if($(q_type).val()=='5'){
			 
			for(var k=0; k<=10; k++){
				var answer_value="answer_value"+qn+'-'+k;
				if(document.getElementById(answer_value)){
					if(document.getElementById(answer_value).value != '0'){	
					document.getElementById(answer_value).value='0';
					}
				}
			}
		 		
		}			
	var did='#qbtn'+qn;
	$(did).css('backgroundColor','#c9302c');
	$(did).css('color','#ffffff');
}

var review_later;
function review_later(){
	
 
	if(review_later[qn] && review_later[qn]){
	
		review_later[qn]=0;
		var did='#qbtn'+qn;
	$(did).css('backgroundColor','#c9302c');
			$(did).css('color','#ffffff');	
	}else{
		
		review_later[qn]=1;
	var did='#qbtn'+qn;
	$(did).css('backgroundColor','#ec971f');
	$(did).css('color','#ffffff');
	}
	
}




function save_answer(qn){
	
								// signal 1
							$('#save_answer_signal1').css('backgroundColor','#00ff00');
								setTimeout(function(){
							$('#save_answer_signal1').css('backgroundColor','#666666');		
								},5000);
								
								    var str = $( "form" ).serialize();
 
 
						// var formData = {user_answer:str};
						$.ajax({
							 type: "POST",
							 data : str,
								url: base_url + "index.php/quiz/save_answer/",
							success: function(data){
							// signal 1
							$('#save_answer_signal2').css('backgroundColor','#00ff00');
								setTimeout(function(){
							$('#save_answer_signal2').css('backgroundColor','#666666');		
								},5000);
								
								},
							error: function(xhr,status,strErr){
								//alert(status);
								
							// signal 1
							$('#save_answer_signal2').css('backgroundColor','#ff0000');
								setTimeout(function(){
							$('#save_answer_signal2').css('backgroundColor','#666666');		
								},5500);

								}	
							});
	 		
		 
	
}

function save_answer_ist(qn){
	
								// signal 1
							$('#save_answer_signal1').css('backgroundColor','#00ff00');
								setTimeout(function(){
							$('#save_answer_signal1').css('backgroundColor','#666666');		
								},5000);
								
								    var str = $( "form" ).serialize();
 
 
						// var formData = {user_answer:str};
						$.ajax({
							 type: "POST",
							 data : str,
								url: base_url + "index.php/ujian/save_answer/",
							success: function(data){
							// signal 1
							$('#save_answer_signal2').css('backgroundColor','#00ff00');
								setTimeout(function(){
							$('#save_answer_signal2').css('backgroundColor','#666666');		
								},5000);
								
								},
							error: function(xhr,status,strErr){
								//alert(status);
								
							// signal 1
							$('#save_answer_signal2').css('backgroundColor','#ff0000');
								setTimeout(function(){
							$('#save_answer_signal2').css('backgroundColor','#666666');		
								},5500);

								}	
							});
	 		
		 
	
}

function save_answer_disc(qn){
	
								// signal 1
							$('#save_answer_signal1').css('backgroundColor','#00ff00');
								setTimeout(function(){
							$('#save_answer_signal1').css('backgroundColor','#666666');		
								},5000);
								
								    var str = $( "form" ).serialize();
 
 
						// var formData = {user_answer:str};
						$.ajax({
							 type: "POST",
							 data : str,
								url: base_url + "index.php/ujian/save_answer_disc/",
							success: function(data){
							// signal 1
							$('#save_answer_signal2').css('backgroundColor','#00ff00');
								setTimeout(function(){
							$('#save_answer_signal2').css('backgroundColor','#666666');		
								},5000);
								
								},
							error: function(xhr,status,strErr){
								//alert(status);
								
							// signal 1
							$('#save_answer_signal2').css('backgroundColor','#ff0000');
								setTimeout(function(){
							$('#save_answer_signal2').css('backgroundColor','#666666');		
								},5500);

								}	
							});
	 		
		 
	
}


function setIndividual_time(cqn){
	if(cqn==undefined || cqn == null ){
		var cqn='0';
	}
		  if(cqn=='0'){
		ind_time[qn]=parseInt(ind_time[qn])+parseInt(ctime);	
		 
		  }else{
			  
			ind_time[cqn]=parseInt(ind_time[cqn])+parseInt(ctime);	
		  
		  }
	
	ctime=0;
	  
	 document.getElementById('individual_time').value=ind_time.toString();
	 
	 var iid=document.getElementById('individual_time').value;
	 
	 	 
	var formData = {individual_time:iid};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/quiz/set_ind_time",
		success: function(data){
	 	
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
		
}

function setIndividual_time_ist(cqn){
	if(cqn==undefined || cqn == null ){
		var cqn='0';
	}
		  if(cqn=='0'){
		ind_time[qn]=parseInt(ind_time[qn])+parseInt(ctime);	
		 
		  }else{
			  
			ind_time[cqn]=parseInt(ind_time[cqn])+parseInt(ctime);	
		  
		  }
	
	ctime=0;
	  
	 document.getElementById('individual_time').value=ind_time.toString();
	 
	 var iid=document.getElementById('individual_time').value;
	 
	 	 
	var formData = {individual_time:iid};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/ujian/set_ind_time",
		success: function(data){
	 	
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
		
}




function submit_quiz(){
	save_answer(qn);
	setIndividual_time(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
	window.location=base_url+"index.php/quiz/submit_quiz/";
	},3000);
}

function submit_ujian_se(){
	window.location=base_url+"index.php/ujian/submit_quiz_se/";
	save_answer_ist(qn);
	setIndividual_time_ist(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
		window.location=base_url+"index.php/ujian/submit_quiz_se/";
	},1000);
}

function submit_ujian_wa(){
	window.location=base_url+"index.php/ujian/submit_quiz_wa/";
	save_answer_ist(qn);
	setIndividual_time_ist(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
		window.location=base_url+"index.php/ujian/submit_quiz_wa/";
	},1000);
}

function submit_ujian_an(){
	window.location=base_url+"index.php/ujian/submit_quiz_an/";
	save_answer_ist(qn);
	setIndividual_time_ist(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
		window.location=base_url+"index.php/ujian/submit_quiz_an/";
	},1000);
}

function submit_ujian_ge(){
	window.location=base_url+"index.php/ujian/submit_quiz_ge/";
	save_answer_ist(qn);
	setIndividual_time_ist(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
		window.location=base_url+"index.php/ujian/submit_quiz_ge/";
	},1000);
}

function submit_ujian_ra(){
	window.location=base_url+"index.php/ujian/submit_quiz_ra/";
	save_answer_ist(qn);
	setIndividual_time_ist(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
		window.location=base_url+"index.php/ujian/submit_quiz_ra/";
	},1000);
}

function submit_ujian_zr(){
	window.location=base_url+"index.php/ujian/submit_quiz_zr/";
	save_answer_ist(qn);
	setIndividual_time_ist(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
		window.location=base_url+"index.php/ujian/submit_quiz_zr/";
	},1000);
}

function submit_ujian_fa(){
	window.location=base_url+"index.php/ujian/submit_quiz_fa/";
	save_answer_ist(qn);
	setIndividual_time_ist(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
		window.location=base_url+"index.php/ujian/submit_quiz_fa/";
	},1000);
}

function submit_ujian_wu(){
	window.location=base_url+"index.php/ujian/submit_quiz_wu/";
	save_answer_ist(qn);
	setIndividual_time_ist(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
		window.location=base_url+"index.php/ujian/submit_quiz_wu/";
	},1000);
}

function submit_ujian_me(){
	window.location=base_url+"index.php/ujian/submit_quiz_me/";
	save_answer_ist(qn);
	setIndividual_time_ist(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
		window.location=base_url+"index.php/ujian/submit_quiz_me/";
	},1000);
}

function submit_ujian_disc(){
	window.location=base_url+"index.php/ujian/submit_quiz_disc/";
	save_answer_disc(qn);
	setIndividual_time_ist(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
		window.location=base_url+"index.php/ujian/submit_quiz_disc/";
	},1000);
}

function switch_category(c_k){
	
	var did=document.getElementById(c_k).value;
	show_question(did);
	
}


function count_char(answer,span_id){
	var chcount=answer.split(' ').length;
	if(answer == ''){
		chcount=0;
	}
	document.getElementById(span_id).innerHTML=chcount; 
	
}



function sort_result(limit,val){
	window.location=base_url+"index.php/result/index/"+limit+"/"+val;
	
}


function assign_score(rid,qno,score){
	 var evaluate_warning=	document.getElementById('evaluate_warning').value;
	 if(confirm(evaluate_warning)){
	var formData = {rid:rid};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/quiz/assign_score/"+rid+'/'+qno+'/'+score,
		success: function(data){
	 	var did="#assign_score"+qno;
		$(did).css('display','none');
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});	
	 }
}



function show_question_stat(id){
	var did="#stat-"+id;
	 
	if($(did).css('display')=='none'){
		$(did).css('display','block');
	}else{
		$(did).css('display','none');
	}
	 
}
 

// end - quiz attempt functions 