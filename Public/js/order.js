/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//alert("this is order js");

function $id(s){
	if(typeof s=="object") return s;
	return document.getElementById(s);
}

function n(s){
	console.log(s);
}


//根据参数返回dom元素
function getDomByJson(ele,json,text){
	var o=document.createElement(ele);
	
	if(json!=null){
		for(var k in json){
			o.setAttribute(k,json[k]);
		}
	}
	
	if(text!=null)o.innerHTML=text;
	return o;
}


//添加一行表单
function addTr(){
	//计算表格中tr个数。
	var f=document.forms[0];
	var num=f.getElementsByTagName('tr').length;
	
	var oTr=getDomByJson('tr');
	
	var oTd=getDomByJson('td',{});
	oTd.appendChild(getDomByJson('span',{},num));
	oTr.appendChild(oTd);
	
	var oTd1=getDomByJson('td');
	var oInput1=getDomByJson('input',{'type':"text","name":"order_name[]"});
	oTd1.appendChild(oInput1);
	oTr.appendChild(oTd1);
	
	var oTd2=getDomByJson('td');
	var oInput2=getDomByJson('input',{'type':"text","name":"order_unit[]"});
	oTd2.appendChild(oInput2);
	oTr.appendChild(oTd2);
	
	var oTd3=getDomByJson('td');
	var oInput3=getDomByJson('input',{'type':"text","name":"order_quantity[]","onchange":"calc1("+num+")"});
	oTd3.appendChild(oInput3);
	oTr.appendChild(oTd3);
	
	var oTd4=getDomByJson('td');
	var oInput4=getDomByJson('input',{'type':"text","name":"order_price[]","onchange":"calc1("+num+")"});
	oTd4.appendChild(oInput4);
	oTr.appendChild(oTd4);
	
	var oTd5=getDomByJson('td');
	var oInput5=getDomByJson('input',{'type':"text","disabled":true,value:0});
	oTd5.appendChild(oInput5);
	oTr.appendChild(oTd5);

	var oTd6=getDomByJson('td');
	var oInput6=getDomByJson('input',{'type':"text","name":"order_note"});
	oTd6.appendChild(oInput6);
	oTr.appendChild(oTd6);
		
	var oDiv=$id("moreTr");
	var tbody=oDiv.getElementsByTagName('tbody')[0];//必须使用tbody才能插入成功。
	tbody.appendChild(oTr);
	return false;
}

//每次修改单价或数量时计算小计、和总金额
function calc1(num){
	//获取表格中dom元素。
	var f=document.forms[0];
	var aTr=f.getElementsByTagName('tr');
	var oTr=aTr[num];
	var aInput=oTr.getElementsByTagName("input");
	//判断必须是数字
	if(isNaN(aInput[2].value)){
		//不是数字
		alert("只能填写数字!");
		aInput[2].value=0;
		aInput[2].focus();
	}
	if(isNaN(aInput[3].value)){
		//不是数字
		alert("只能填写数字!");
		aInput[3].value=0;
		aInput[3].focus();
	}
	//计算当前行：	
	aInput[4].value=aInput[3].value*aInput[2].value 
	
	//计算总金额
	var sum=0;
	for(var i=1;i<aTr.length;i++){
		sum += parseInt(aTr[i].getElementsByTagName('input')[4].value);
	}
	$id("total").innerHTML=sum;
}


//提交之前检查是否符合规范
function checkFrom(){
	//获取表格中dom元素。
	var f=document.forms[0];
	var str=f.order_time.value;
	
	//如果不是8位数字不行
	if(!str.match(/^\d{8}$/)){
		alert("日期不能为空，或格式错误。请填写8位数日期：20170101");
		f.order_time.focus();
		return (false);
	}
	
	//如果第一行没有东西，也不行

	return (true);
}



