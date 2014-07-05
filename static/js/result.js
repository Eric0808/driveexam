


 var lookInfo = function(id, category){
	if( category.id == id ){
		return category;
	}else{
		for(var k in category.child){
			if( category.child[k].id == id ){
				return category.child[k];
			}else{
				var cid = lookInfo(id, category.child[k]);
				if(typeof cid !=='undefined' ){
					return cid;
				}
			}
		}
	}
	
 }

 var lookInfoByName = function(name, category){
	if( category.name == name ){
		return category;
	}else{
		for(var k in category.child){
			if( category.child[k].name == name ){
				return category.child[k];
			}else{
				var cid = lookInfoByName(name, category.child[k]);
				if(typeof cid !=='undefined' ){
					return cid;
				}
			}
		}
	}
	
 }
 
 
 var compSocres = function(category, evaluation){
	var  socres = 0;
	for(var k in category.child){
		if( ! category.child[k].hasOwnProperty('child') || category.child[k].child.length==0 ){

			var id = category.child[k].id.toString();
			if( evaluation.hasOwnProperty(id) ){
				socres += evaluation[id].s;
			}
		}else{
			socres += compSocres(category.child[k], evaluation);
		}
	}
	socres = Math.round(socres*10000)/10000;
	return socres;
 }


function showResult(category, evaluation)
{
	this.box = document.getElementById('showResult');

	this.data = {
		chart: {
                renderTo: 'showResult',
                type: 'column'
            },
		plotOptions: {
                column: {
                    stacking: 'normal'
                },
				dataLabels: {
                        enabled: true,
                        color: '#C0C0C0',
                        style: {
                            fontWeight: 'bold'
                        }
                }
            },
    
        xAxis: {
				categories: [],
				labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'arial,宋体b8b\4f53,sans-serif'
                    }
                }

            },
    
        yAxis: {
                // allowDecimals: false,
                min: 0,
                title: {
                    text: '分数'
                },
		        stackLabels: {
					enabled: true,
					style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    },
					formatter: function(){
							return this.total;
					}
				}
				
            },
    
		exporting: {
                enabled: true
            },
		legend: {
				enabled:false
            },
		
        tooltip: {
                formatter: function() {
					var cid = lookInfoByName(this.series.name, category);
					if(typeof cid === 'undefined'){
						return false;
					}
					var evaluationstr = '';
					for(var k in evaluation){
						if( k == cid.id ){
							evaluationstr = evaluation[k].e;
							continue;
						}
					}
					if(evaluationstr == ''){
						evaluationstr = '暂无';
					}
					
                    return '<b>'+ this.series.name +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        '总分: '+ this.point.stackTotal + '<br/>' +
						'评价: '+ evaluationstr + '<br/>'
                }
            }
	};

	this.get = function(){
	
		this.data.title = {};
		this.data.title.text = category.name + ' 考试成绩  (总分:' +
							compSocres(categoryList, evaluation) +')';
							
		if( typeof username == 'string' ){
			this.data.title.text = username + ' 的 ' + this.data.title.text;
		}
		
		var series = new Array();
		var total = new Array();
		
		for(var cid in evaluation){
			var info = lookInfo(cid, category);
			
			this.data.xAxis.categories.push('');
			this.data.xAxis.categories.push(info.name);

			// this.data.xAxis.categories.push(info.name);
			// this.data.xAxis.categories.push('');

			var r = {};
			r.name = 'total'; // +info.name;
			r.data = [info.weight-evaluation[cid].s];
			r.stack= 'm'+ info.name;
			r.color= '#C0C0C0';
			
			series.push(r);
			
			
			
			var data = {};
			data.name = info.name;
			data.data = [evaluation[cid].s]; // , 0, 0, 0, 0];
			data.stack= 'm'+ info.name;
			
			series.push(data);
		}

		this.data.series = series;
		
		return ;
		
	
	}

	this.show = function(){
		var chart = new Highcharts.Chart(this.data);
		return;
	}

}




