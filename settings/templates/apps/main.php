<?php
/**
 * ownCloud - App Settings
 * @author Robin Appelman
 * @author Raghu Nayyar
 * @copyright (c) 2011, Robin Appelman <icewind1991@gmail.com>
 * @copyright (c) 2013, Raghu Nayyar <raghu.nayyar.007@gmail.com>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
?>
<script
	type="text/javascript"
	src="<?php print_unescaped(OC_Helper::linkToRoute('apps_custom'));?>?appid=<?php p($_['appid']); ?>">
</script>
<script 
	type="text/javascript"
	src="<?php print_unescaped(OC_Helper::linkTo('settings/js/apps', 'apps.js'));?>">
</script>
<div id="app-navigation">
	<?php print_unescaped($this->inc('apps/part.applist')) ?>
</div>
<div id="app-content">
	<?php print_unescaped($this->inc('apps/part.appdetails')); ?>
</div>