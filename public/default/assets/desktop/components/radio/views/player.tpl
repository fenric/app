<div class="container-fluid h-100">
	<div class="row h-100">
		<div class="col-sm-7 pl-0">
			<div class="radio-player">
				<div class="text-center">

					<!-- album cover -->
					<div style="margin-bottom: 20px;">
						{{when desktop.components.radio.player.nowPlaying.album_cover is empty}}
						<img class="radio-player-now-playing-albumcover img-thumbnail" width="100" height="100" src="{{desktop.components.radio.root}}/res/albumcover.jpg" />
						{{endwhen desktop.components.radio.player.nowPlaying.album_cover}}

						{{when desktop.components.radio.player.nowPlaying.album_cover is not empty}}
						<img class="radio-player-now-playing-albumcover img-thumbnail" width="100" height="100" src="{{desktop.components.radio.player.nowPlaying.album_cover}}" />
						{{endwhen desktop.components.radio.player.nowPlaying.album_cover}}
					</div>
					<!-- /album cover -->

					<!-- song title -->
					{{when desktop.components.radio.player.nowPlaying.title is not empty}}
					<div style="margin-bottom: 20px;">
						<h4 class="mt-0 mb-0">{{desktop.components.radio.player.nowPlaying.title}}</h4>
					</div>
					{{endwhen desktop.components.radio.player.nowPlaying.title}}
					<!-- /song title -->

					<!-- control -->
					<div style="margin-bottom: 20px;">
						<div class="btn-group">
							{{when desktop.components.radio.player.station is not empty}}
							<button type="button" class="radio-player-action-now-playing btn btn-sm btn-default" data-id="{{desktop.components.radio.player.station.id}}">
								<i class="fa fa-refresh" aria-hidden="true"></i>
							</button>
							<button type="button" class="btn btn-sm btn-default">
								<i class="fa fa-heart" aria-hidden="true" style="color: red;"></i>
							</button>
							{{endwhen desktop.components.radio.player.station}}

							<button type="button" class="radio-player-action-volume-down btn btn-sm btn-default">
								<i class="fa fa-volume-down" aria-hidden="true"></i>
							</button>
							<button type="button" class="radio-player-action-volume-up btn btn-sm btn-default">
								<i class="fa fa-volume-up" aria-hidden="true"></i>
							</button>
							<button type="button" class="radio-player-action-stop btn btn-sm btn-danger">
								<i class="fa fa-stop" aria-hidden="true"></i>
							</button>
						</div>
					</div>
					<!-- /control -->

					<!-- station -->
					{{when desktop.components.radio.player.station is not empty}}
					<div style="margin-bottom: 10px;">
						<div style="margin-bottom: 2px;">
							<strong>Радиостанция</strong>
						</div>
						<div>
							<span>{{desktop.components.radio.player.station.title}}</span>
						</div>
					</div>
					{{endwhen desktop.components.radio.player.station}}
					<!-- /station -->

					<!-- genre -->
					{{when desktop.components.radio.player.nowPlaying.genre is not empty}}
					<div style="margin-bottom: 10px;">
						<div style="margin-bottom: 2px;">
							<strong>Жанр</strong>
						</div>
						<div>
							<span>{{desktop.components.radio.player.nowPlaying.genre}}</span>
						</div>
					</div>
					{{endwhen desktop.components.radio.player.nowPlaying.genre}}
					<!-- /genre -->

					<!-- artist -->
					{{when desktop.components.radio.player.nowPlaying.artist is not empty}}
					<div style="margin-bottom: 10px;">
						<div style="margin-bottom: 2px;">
							<strong>Артист</strong>
						</div>
						<div>
							{{when desktop.components.radio.player.nowPlaying.artist_url is empty}}
							<span>{{desktop.components.radio.player.nowPlaying.artist}}</span>
							{{endwhen desktop.components.radio.player.nowPlaying.artist_url}}

							{{when desktop.components.radio.player.nowPlaying.artist_url is not empty}}
							<a href="{{desktop.components.radio.player.nowPlaying.artist_url}}" target="_blank">
								<span>{{desktop.components.radio.player.nowPlaying.artist}}</span>
							</a>
							{{endwhen desktop.components.radio.player.nowPlaying.artist_url}}
						</div>
					</div>
					{{endwhen desktop.components.radio.player.nowPlaying.artist}}
					<!-- /artist -->

					<!-- album -->
					{{when desktop.components.radio.player.nowPlaying.album is not empty}}
					<div style="margin-bottom: 10px;">
						<div style="margin-bottom: 2px;">
							<strong>Альбом</strong>
						</div>
						<div>
							{{when desktop.components.radio.player.nowPlaying.album_url is empty}}
							<span>{{desktop.components.radio.player.nowPlaying.album}}</span>
							{{endwhen desktop.components.radio.player.nowPlaying.album_url}}

							{{when desktop.components.radio.player.nowPlaying.album_url is not empty}}
							<a href="{{desktop.components.radio.player.nowPlaying.album_url}}" target="_blank">
								<span>{{desktop.components.radio.player.nowPlaying.album}}</span>
							</a>
							{{endwhen desktop.components.radio.player.nowPlaying.album_url}}
						</div>
					</div>
					{{endwhen desktop.components.radio.player.nowPlaying.album}}
					<!-- /album -->

					<!-- track -->
					{{when desktop.components.radio.player.nowPlaying.track is not empty}}
					<div style="margin-bottom: 10px;">
						<div style="margin-bottom: 2px;">
							<strong>Трек</strong>
						</div>
						<div>
							{{when desktop.components.radio.player.nowPlaying.track_url is empty}}
							<span>{{desktop.components.radio.player.nowPlaying.track}}</span>
							{{endwhen desktop.components.radio.player.nowPlaying.track_url}}

							{{when desktop.components.radio.player.nowPlaying.track_url is not empty}}
							<a href="{{desktop.components.radio.player.nowPlaying.track_url}}" target="_blank">
								<span>{{desktop.components.radio.player.nowPlaying.track}}</span>
							</a>
							{{endwhen desktop.components.radio.player.nowPlaying.track_url}}

							{{when desktop.components.radio.player.nowPlaying.track_preview is not empty}}
							<div style="margin-top: 2px;">
								<a href="{{desktop.components.radio.player.nowPlaying.track_preview}}" target="_blank">
									<i class="fa fa-download" aria-hidden="true"></i>
								</a>
							</div>
							{{endwhen desktop.components.radio.player.nowPlaying.track_preview}}
						</div>
					</div>
					{{endwhen desktop.components.radio.player.nowPlaying.track}}
					<!-- /track -->

					<!-- release -->
					{{when desktop.components.radio.player.nowPlaying.release is not empty}}
					<div style="margin-bottom: 10px;">
						<div style="margin-bottom: 2px;">
							<strong>Релиз</strong>
						</div>
						<div>
							<span>{{desktop.components.radio.player.nowPlaying.release:datetime(d.m.Y)}}</span>
						</div>
					</div>
					{{endwhen desktop.components.radio.player.nowPlaying.release}}
					<!-- /release -->
				</div>
			</div>
		</div>
		<div class="col-sm-5 h-100 pr-0" style="overflow-y: auto;">
			<div class="list-group">
				{{repeat stations}}
					{{when id is equal | this.desktop.components.radio.player.station.id}}
						<button class="list-group-item radio-player-station radio-player-action-play active" data-id="{{id}}">
							<span>{{title}}</span>
						</button>
					{{endwhen id}}

					{{when id is not equal | this.desktop.components.radio.player.station.id}}
						<button class="list-group-item radio-player-station radio-player-action-play" data-id="{{id}}">
							<span>{{title}}</span>
						</button>
					{{endwhen id}}
				{{endrepeat stations}}

				<button class="list-group-item list-group-item-warning" onclick="$desktop.component('radio').list()">
					<span>Управление радиостанциями</span>
				</button>
			</div>
		</div>
	</div>
</div>
