$(function(){

//グローバル変数
var nowModalSyncer = null ;		//現在開かれているモーダルコンテンツ
var modalClassSyncer = "modal-syncer" ;		//モーダルを開くリンクに付けるクラス名

//モーダルのリンクを取得する
var modals = document.getElementsByClassName(modalClassSyncer);

//モーダルウィンドウを出現させるクリックイベント
for(var i=0,l=modals.length; l>i; i++){

	//全てのリンクにタッチイベントを設定する
	modals[i].onclick = function(){

		//ターゲットとなるコンテンツを確認
		var target = this.getAttribute("data-target");

		//ターゲットが存在しなければ終了
		if(typeof(target)=="undefined" || !target || target==null){
			return false ;
		}

		//コンテンツとなる要素を取得
		nowModalSyncer = document.getElementById(target);

		//ターゲットが存在しなければ終了
		if(nowModalSyncer==null){
			return false ;
		}

		//オーバーレイを出現させる
		$("body").append('<div id="modal-overlay"></div>');
		$("#modal-overlay").fadeIn("fast");

		//コンテンツをセンタリングする
		centeringModalSyncer();

		//コンテンツをフェードインする
		$(nowModalSyncer).fadeIn("slow");

		//[#modal-overlay]、または[#modal-close]をクリックしたら…
		$("#modal-overlay,#modal-close").unbind().click(function(){

			//[#modal-content]と[#modal-overlay]をフェードアウトした後に…
			$("#" + target + ",#modal-overlay").fadeOut("fast",function(){

				//[#modal-overlay]を削除する
				$('#modal-overlay').remove();

			});

			//現在のコンテンツ情報を削除
			nowModalSyncer = null ;

		});

	}

}

	//リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
	$(window).resize(centeringModalSyncer);

	//センタリングを実行する関数
	function centeringModalSyncer(){

		//モーダルウィンドウが開いてなければ終了
		if(nowModalSyncer == null) return false ;

		//画面(ウィンドウ)の幅、高さを取得
		var w = $(window).width();
		var h = $(window).height();

		//コンテンツ(#modal-content)の幅、高さを取得
		var cw = $(nowModalSyncer).outerWidth({margin:true});
		var ch = $(nowModalSyncer).outerHeight({margin:true});

		//センタリングを実行する
		$(nowModalSyncer).css({"left": ((w - cw)/2) + "px","top": ((h - ch)/2) + "px"})

	}

});
