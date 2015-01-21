<?php
	// GitHib Repo Lister - API demo code
	// Author: Simon Prickett

	// Hit the GitHub API and list the repos, will expect
	// to be passed a GitHub token in GITHUB_TOKEN environment variable
	function listGitHubRepos() {
		global $gitHubToken;

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, "https://api.github.com/user/repos");
		curl_setopt($c, CURLOPT_CUSTOMREQUEST, "GET");  
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($c, CURLOPT_HTTPHEADER, array( 
			"User-Agent: Modus PHP Script",                                                                         
    		"Content-Type: application/json",  
    		"Accept-Language: en-US",  
    		"Authorization: token " . $_ENV["GITHUB_TOKEN"])                                                                            
		);    

		$output = curl_exec($c);

		$gitHubReposJSON = json_decode($output, true);
		curl_close($c);

		$htmlStr = '<ul class="repolist">';
		foreach($gitHubReposJSON as $gitHubRepo) {
			$htmlStr = $htmlStr . '<li><a href="' . $gitHubRepo['url'] . '">' . $gitHubRepo['id'] . ' ' . $gitHubRepo['name'] . '</a></li>';
		}

		$htmlStr = $htmlStr . '</ul>';
		print $htmlStr;
	}
?>
<html>
	<head>
		<title>GitHub Repo Lister</title>
	</head>
	<body>
		<h1>GitHub Repo Lister</h1>
		<p>Here are your GitHub Repos:</p>
		<?php listGitHubRepos(); ?>
	</body>
</html>