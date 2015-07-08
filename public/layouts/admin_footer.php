
					</div><!-- row -->
				</div><!-- container -->
			</div><!-- mainContent -->

			<footer>
				<div class="container">
					<div class="row">
						<div id="liscene">
							<p>
							Copyright &copy; <?php echo date("Y", time()); ?> by Abhishek Gupta. All Rights Reserved.
							</p>
						</div>
					</div><!-- row -->
				</div><!-- container -->
			</footer>

		</div><!-- bodyWrapper -->

	
		<!-- Main Script -->
		<script src="public/js/main.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="public/bootstrap/bootstrap.min.js"></script>

	</body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>