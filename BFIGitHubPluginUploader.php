<?php


class BFIGitHubPluginUpdater {
 
    private $slug; // plugin slug
    private $pluginData; // plugin data
    private $username; // GitHub username
    private $repo; // GitHub repo name
    private $pluginFile; // __FILE__ of our plugin
    private $githubAPIResult; // holds data from GitHub
    private $accessToken; // GitHub private repo token
 
    function __construct( $pluginFile, $gitHubUsername, $gitHubProjectName, $accessToken = '' ) {
        add_filter( "pre_set_site_transient_update_plugins", array( $this, "setTransitent" ) );
        add_filter( "plugins_api", array( $this, "setPluginInfo" ), 10, 3 );
        add_filter( "upgrader_post_install", array( $this, "postInstall" ), 10, 3 );
        add_shortcode( 'api_call', array( $this, 'getRepoReleaseInfo' ) );
 
        $this->pluginFile = $pluginFile;
        $this->username = $gitHubUsername;
        $this->repo = $gitHubProjectName;
        $this->accessToken = $accessToken;
    }
    
    
 
    // Get information regarding our plugin from WordPress
    private function initPluginData() {
        // code here
        $this->slug = plugin_basename( $this->pluginFile );
        $this->pluginData = get_plugin_data( $this->pluginFile );
    }
 
    // Get information regarding our plugin from GitHub
    public function getRepoReleaseInfo() 
    {
        // Only do this once
        if ( ! empty( $this->githubAPIResult ) ) 
        {
            return;
        }
        // Query the GitHub API
        $url = "https://api.github.com/repos/{$this->username}/{$this->repo}/releases";
 
        // We need the access token for private repos
        if ( ! empty( $this->accessToken ) ) 
        {
            $url = add_query_arg( array( "access_token" => $this->accessToken ), $url );
        }
 
        // Get the results
        $this->githubAPIResult = wp_remote_retrieve_body( wp_remote_get( $url ) );
        if ( ! empty( $this->githubAPIResult ) ) 
        {
            $this->githubAPIResult = @json_decode( $this->githubAPIResult );
        }
        // Use only the latest release
        if ( is_array( $this->githubAPIResult ) ) 
        {
            d($this->githubAPIResult = $this->githubAPIResult[0]);
            #s($this->githubAPIResult = $this->githubAPIResult[0]);
        }
        
    }
 
    // Push in plugin version information to get the update notification
    public function setTransitent( $transient ) {
        // code here
        return $transient;
    }
 
    // Push in plugin version information to display in the details lightbox
    public function setPluginInfo( $false, $action, $response ) {
        // code ehre
        return $response;
    }
 
    // Perform additional actions to successfully install our plugin
    public function postInstall( $true, $hook_extra, $result ) {
        // code here
        return $result;
    }
}
