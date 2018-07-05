<?php
/**
 * Admin Pages
 *
 * @author 8guild
 */

if ( ! is_admin() ) {
	return;
}

/**
 * Add "Silicon" page under the Dashboard
 */
function silicon_core_add_silicon_page() {
	add_menu_page(
		__( 'Silicon', 'silicon' ),
		__( 'Silicon', 'silicon' ),
		'read',
		'silicon',
		'silicon_core_do_welcome_page',
		'none',
		'3.33'
	);

	add_submenu_page(
		'silicon',
		__( 'Welcome', 'silicon' ),
		__( 'Welcome', 'silicon' ),
		'read',
		'silicon',
		'silicon_core_do_welcome_page'
	);

	add_submenu_page(
		'silicon',
		__( 'Silicon Quick Help', 'silicon' ),
		__( 'Quick Help', 'silicon' ),
		'read',
		'silicon-help',
		'silicon_core_do_help_page'
	);
}

add_action( 'admin_menu', 'silicon_core_add_silicon_page' );

/**
 * Add external link to Theme Online Docs into the Theme area
 */
function silicon_core_external_docs_link() {
	global $submenu;

	$submenu['silicon'][] = array( esc_html__( 'Documentation', 'silicon' ), 'read', 'http://silicon.8guild.com/docs/' );
}

add_action( 'admin_menu', 'silicon_core_external_docs_link' );

/**
 * Render the contents of Theme > Welcome page
 */
function silicon_core_do_welcome_page() {
	?>
	<div class="wrap">
		<div class="silicon-admin-page-wrap">
			<div class="column">
				<h1>Welcome</h1>
				<p>Thank you for purchasing our theme. We are happy that you are one of our customers and we assure you won't be disappointed. We do our best to produce top notch themes with great functionality, premium designs and human readable code. Before you get started we highly encourage you to get familiar with this documentation file. Spending half an hour reading the manual may save a lot of your time and avoid questions with obvious answers.</p>
				<p>If you have any questions that are beyond the scope of the help file, please feel free to post your questions on our support forum at <a href="https://8guild.ticksy.com/" target="_blank">https://8guild.ticksy.com/</a></p>
				<p><strong>PLEASE NOTE!</strong> Our support covers getting setup, trouble using any features, and any bug fixes that may arise. Unfortunately, we cannot provide support for customizations or 3rd party plugins. If you need help with customizations of your theme, then you should ask for help from a developer.</p>
			</div>
			<div class="column"></div>
		</div>
		<div class="silicon-admin-page-wrap">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=silicon-options' ) ); ?>" class="link-box update-nag silicon-theme-options">
				<div class="icon"></div>
				<h3>Theme Options</h3>
				<p>Change colors, fonts, sizes, behaviour of elements within super powerful Theme options panel.</p>
				<span class="btn">Go to Options</span>
			</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=silicon-help' ) ); ?>" class="link-box update-nag silicon-quick-help">
				<div class="icon"></div>
				<h3>Quick Help</h3>
				<p>List of all helper classes you can use within Extra Class field inside any Shortcode settings window.</p>
				<span class="btn">Visit Quick Help</span>
			</a>
			<a href="http://silicon.8guild.com/docs/" class="link-box update-nag silicon-docs" target="_blank">
				<div class="icon"></div>
				<h3>Documentation</h3>
				<p>Online documentation that covers all aspects of Theme and Plugins installation and usage.</p>
				<span class="btn">View Documentation</span>
			</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=silicon-import' ) ); ?>" class="link-box update-nag silicon-demo-import">
				<div class="icon"></div>
				<h3>Demo Import</h3>
				<p>One-Click demo import helps you to get started fast and easy. You only need to upload chosen demo file.</p>
				<span class="btn">Start Importing</span>
			</a>
			<a href="https://8guild.ticksy.com/" class="link-box update-nag silicon-support">
				<div class="icon"></div>
				<h3>Premium Support</h3>
				<p>Answering your support questions can take up to 2 business days. We are here to help!</p>
				<span class="btn">Get Support</span>
			</a>
			<a href="https://themeforest.net/item/silicon-startup-and-technology-wordpress-theme/20082761" class="link-box update-nag silicon-rating">
				<div class="icon"></div>
				<h3>Rate Theme</h3>
				<p>We put a lot of effort to make this theme and we will highly appreciate your rating.</p>
				<span class="btn">Give Us 5</span>
			</a>
			<a href="https://themeforest.net/item/silicon-startup-and-technology-wordpress-theme/20082761?license=regular&open_purchase_for_item_id=20082761&purchasable=source&ref=8guild" class="link-box update-nag silicon-buy">
				<div class="icon"></div>
				<h3>Buy Another Copy</h3>
				<p>If you enjoy working with our theme you may consider buying another copy for other project.</p>
				<span class="btn">Buy Theme</span>
			</a>
		</div>
	</div>
	<?php
}

/**
 * Render the contents of Theme > Quick Help page
 */
function silicon_core_do_help_page() {
	?>
    <div class="wrap">
        <div class="silicon-admin-page-wrap">
            <h1>Quick Help</h1>
            <p class="description-box update-nag">Here you find the list of all helper classes you can use within
                <strong>Extra Class field</strong> inside any <strong>Shortcode settings</strong> window.</p>
            <h2>Vertical Align Classes</h2>
            <p class="short-description">Responsive paddings and margins for adding vertical spaces to your page element (Shortcodes)</p>
        </div>
        <div class="silicon-admin-page-wrap">
            <div class="column">
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>Class Name</th>
                            <th>Description</th>
                        </tr>
                        <tr>
                            <td class="white">
                                <pre>margin-top-1x<br>margin-top-2x<br>margin-top-3x<br>margin-top-4x<br>margin-top-5x<br>margin-top-6x<br>margin-top-7x<br>margin-top-8x<br>margin-top-9x<br>margin-top-10x</pre>
                            </td>
                            <td>Set the <strong>Top Margin</strong> for target element to
                                24/48/72/96/120/144/168/192/216/240px on Desctop and 16/36/48/64/80/96/112/128/144/160px
                                on Mobile respectively. Each step (x) is equal 24px/16px on Desktop/Mobile.
                            </td>
                        </tr>
                        <tr>
                            <td class="white">
                                <pre>margin-bottom-1x<br>margin-bottom-2x<br>margin-bottom-3x<br>margin-bottom-4x<br>margin-bottom-5x<br>margin-bottom-6x<br>margin-bottom-7x<br>margin-bottom-8x<br>margin-bottom-9x<br>margin-bottom-10x</pre>
                            </td>
                            <td>Set the <strong>Bottom Margin</strong> for target element to
                                24/48/72/96/120/144/168/192/216/240px on Desctop and 16/36/48/64/80/96/112/128/144/160px
                                on Mobile respectively. Each step (x) is equal 24px/16px on Desktop/Mobile.
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="column">
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>Class Name</th>
                            <th>Description</th>
                        </tr>
                        <tr>
                            <td class="white">
                                <pre>padding-top-1x<br>padding-top-2x<br>padding-top-3x<br>padding-top-4x<br>padding-top-5x<br>padding-top-6x<br>padding-top-7x<br>padding-top-8x<br>padding-top-9x<br>padding-top-10x</pre>
                            </td>
                            <td>Set the <strong>Top Padding</strong> for target element to
                                24/48/72/96/120/144/168/192/216/240px on Desctop and 16/36/48/64/80/96/112/128/144/160px
                                on Mobile respectively. Each step (x) is equal 24px/16px on Desktop/Mobile.
                            </td>
                        </tr>
                        <tr>
                            <td class="white">
                                <pre>padding-bottom-1x<br>padding-bottom-2x<br>padding-bottom-3x<br>padding-bottom-4x<br>padding-bottom-5x<br>padding-bottom-6x<br>padding-bottom-7x<br>padding-bottom-8x<br>padding-bottom-9x<br>padding-bottom-10x</pre>
                            </td>
                            <td>Set the <strong>Bottom Padding</strong> for target element to
                                24/48/72/96/120/144/168/192/216/240px on Desctop and 16/36/48/64/80/96/112/128/144/160px
                                on Mobile respectively. Each step (x) is equal 24px/16px on Desktop/Mobile.
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="silicon-admin-page-wrap">
            <div class="column">
                <h2>Display, Positioning &amp; Overflow</h2>
                <p class="short-description">To alter display / position style of target element (Shortcode).</p>
                <div class="table-responsive" style="margin-bottom: 40px;">
                    <table>
                        <tr>
                            <th>Class Name</th>
                            <th>Description</th>
                        </tr>
                        <tr>
                            <td class="white">block</td>
                            <td>To change <strong>display property</strong> of target element to <strong>block</strong>.
                                Useful for cases when you need to remove bottom extra gap from Single Image shortcode
                                (-webkit bug).
                            </td>
                        </tr>
                        <tr>
                            <td class="white">inline-block</td>
                            <td>To change <strong>display property</strong> of target element to
                                <strong>inline-block</strong>.
                            </td>
                        </tr>
                        <tr>
                            <td class="white">block-center</td>
                            <td>To change <strong>display property</strong> of target element to <strong>block</strong>
                                and horizontal alignment to center.
                            </td>
                        </tr>
                        <tr>
                            <td class="white">relative</td>
                            <td>To change <strong>position property</strong> of target element to
                                <strong>relative</strong>. Useful for cases when you need to place absolutely bositioned
                                element inside target element.
                            </td>
                        </tr>
                        <tr>
                            <td class="white">absolute</td>
                            <td>To change <strong>position property</strong> of target element to
                                <strong>absolute</strong>.
                            </td>
                        </tr>
                        <tr>
                            <td class="white">overflow-hidden</td>
                            <td>To change <strong>overflow property</strong> of target element to
                                <strong>hidden</strong>.
                            </td>
                        </tr>
                    </table>
                </div>
                <h2>Text Alignment</h2>
                <p class="short-description">To align text within target element (Shortcode).</p>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>Class Name</th>
                            <th>Description</th>
                        </tr>
                        <tr>
                            <td class="white">text-left</td>
                            <td>Aligns the text to the left.</td>
                        </tr>
                        <tr>
                            <td class="white">text-center</td>
                            <td>Aligns the text to the right.</td>
                        </tr>
                        <tr>
                            <td class="white">text-right</td>
                            <td>Centers the text.</td>
                        </tr>
                        <tr>
                            <td class="white">text-justify</td>
                            <td>Stretches the lines so that each line has equal width.</td>
                        </tr>
                        <tr>
                            <td class="white">text-nowrap</td>
                            <td>Sequences of whitespace will collapse into a single whitespace. Text will never wrap to
                                the next line.
                            </td>
                        </tr>
                        <tr>
                            <td class="white">tablet-center</td>
                            <td>Centers the text on Small devices: Tablets (≥768px)</td>
                        </tr>
                        <tr>
                            <td class="white">mobile-center</td>
                            <td>Centers the text on Extra small devices: Phones (&lt;768px)</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="column">
                <h2>Responsive Utilities</h2>
                <p class="short-description">For faster mobile-friendly development, use these utility classes for
                    showing and hiding content by device via media query.</p>
                <div class="table-responsive">
                    <table>
                        <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Extra small devices<br>
                                <small>Phones (&lt;768px)</small>
                            </th>
                            <th>Small devices<br>
                                <small>Tablets (≥768px)</small>
                            </th>
                            <th>Medium devices<br>
                                <small>Desktops (≥992px)</small>
                            </th>
                            <th>Large devices<br>
                                <small>Desktops (≥1200px)</small>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="white">visible-xs</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-hidden">Hidden</td>
                        </tr>
                        <tr>
                            <td class="white">visible-sm</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-hidden">Hidden</td>
                        </tr>
                        <tr>
                            <td class="white">visible-md</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-hidden">Hidden</td>
                        </tr>
                        <tr>
                            <td class="white">visible-lg</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-visible">Visible</td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <td class="white">hidden-xs</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-visible">Visible</td>
                        </tr>
                        <tr>
                            <td class="white">hidden-sm</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-visible">Visible</td>
                        </tr>
                        <tr>
                            <td class="white">hidden-md</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-hidden">Hidden</td>
                            <td class="is-visible">Visible</td>
                        </tr>
                        <tr>
                            <td class="white">hidden-lg</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-visible">Visible</td>
                            <td class="is-hidden">Hidden</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
	<?php
}
