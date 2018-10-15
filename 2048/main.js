$(function(){
	game.init();
});

var game = {
	rows : 4,
	cols : 4,
	spaceWidth : 20,
	spaceHeight : 20,
	boxWidth : 100,
	boxHeight : 100,
	viewsArr : [],
	gameBtn : false,
	init : function(){
		// 初始化界面和数字格子
		this.setView();

		// 生成两个随机位置的随机数字
		this.setOneNumber();
		this.setOneNumber();

		// 开始游戏
		this.beginGame();
	},
	// 创建4*4的格子,并且计算位置top/left
	setView : function(){
		for(var i = 0; i < this.rows; i++){
			this.viewsArr[i] = [];
			for(var j = 0; j < this.cols; j++){
				this.viewsArr[i][j] = 0;
				var html = '<div id="box-' + i + '-' + j + '" class="box"></div>';
				$(".main").append(html);
				$("#box-" + i + "-" + j).css("top", this.setPosTop(i, j));
				$("#box-" + i + "-" + j).css("left", this.setPosLeft(i, j));
			}
		}
		this.setGameView();
	},
	setPosTop : function(i, j){
		return (this.spaceHeight + (this.spaceHeight + this.boxHeight) * i) + "px";
	},
	setPosLeft : function(i, j){
		return (this.spaceWidth + (this.spaceWidth + this.boxWidth) * j) + "px";
	},
	setGameView : function(){
		for(var i = 0; i < this.rows; i++){
			for(var j = 0; j < this.cols; j++){
				$(".main").append('<div id="number-' + i + '-' + j + '" class="number"></div>');
				var number = $("#number-" + i + "-" + j);
				if(!this.viewsArr[i][j]){
					number.css("width","0px");
					number.css("height","0px");
					number.css("top", this.setPosTop(i, j));
					number.css("left", this.setPosLeft(i, j));
				}else{
					// number.css("width", this.boxWidth + "px");
					// number.css("height", this.boxHeight + "px");
					// number.css("top", this.setPosTop(i, j));
					// number.css("left", this.setPosLeft(i, j));
					// number.css("background-color", "red");
					// number.css("color", "blue");
					// number.html(this.viewsArr[i][j]);
				}
			}
		}
	},
	// 生成一个随机位置随机数字
	setOneNumber : function(){
		// 生成一个随机位置
		var randX = Math.floor(Math.random() * 4);
		var randY = Math.floor(Math.random() * 4);
		// console.log(randX+"-"+randY);
		while(true){
			console.log(1)
			// 当前数字格子没有数字就满足条件
			if(this.viewsArr[randX][randY] == 0){
				break;
			}
			// 否则重新生成位置
			var randX = Math.floor(Math.random() * 4);
			var randY = Math.floor(Math.random() * 4);
		}

		// 生成一个随机数字
		var randNumber = Math.random() < 0.5 ? 2 : 4;
		// console.log(randNumber);
		 
		// 在随机位置显示随机数字
		this.viewsArr[randX][randY] = randNumber;
		// 数字显示动画
		$("#number-"+randX+"-"+randY).html(randNumber);
		$("#number-"+randX+"-"+randY).addClass("animate");
	},
	setkeyEvent : function(){
		var _this = this;
		$(document).keydown(function(event){
			switch(event.keyCode){
				case 37:
				// 键盘按下（左事件）
				if(_this.setKeyMOveLeft()){
					_this.setOneNumber();
					_this.isGameOver();
				}
					break;
				case 38:
				// 键盘按下（上事件）
				_this.setKeyMoveUp();
					break;
				case 39:
				// 键盘按下（右事件）
				_this.setKeyMoveRight();
					break;
				case 40:
				// 键盘按下（下事件）
				_this.setKeyMoveDown();
					break;
			}
		});
	},
	// 开始游戏
	beginGame : function(){
		var _this = this;
		$("#begin").on("click", function(){
			if(!_this.gameBtn){
				_this.gameBtn = true;
				_this.setkeyEvent();
			}else{
				// 游戏提示
				alert("游戏正在进行");
				// 游戏重置
				// xxx
			}
		});
	},
	setKeyMOveLeft : function(){
		return true;
	},
	setKeyMoveUp : function(){},
	setKeyMoveRight : function(){},
	setKeyMoveDown : function(){},
	isGameOver : function(){
	},
	disMoveLeft : function(){

	}
}