<?php
/**
 * This example downloads a completed report. To run a report, run
 * RunDeliveryReportExample.php.
 *
 * Tags: ReportService.getReportDownloadURL
 *
 * PHP version 5
 *
 * Copyright 2012, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsDfp
 * @subpackage v201211
 * @category   WebServices
 * @copyright  2012, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 * @author     Eric Koleda
 */
error_reporting(E_STRICT | E_ALL);

// You can set the include path to src directory or reference
// DfpUser.php directly via require_once.
// $path = '/path/to/dfp_api_php_lib/src';
$path = dirname(__FILE__) . '/../../../../src';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
require_once dirname(__FILE__) . '/../../../Common/ExampleUtils.php';
require_once 'Google/Api/Ads/Dfp/Util/ReportUtils.php';

try {
  // Get DfpUser from credentials in "../auth.ini"
  // relative to the DfpUser.php file's directory.
  $user = new DfpUser();

  // Log SOAP XML request and response.
  $user->LogDefaults();

  // Get the ReportService.
  $reportService = $user->GetService('ReportService', 'v201211');

  // Set the ID of the completed report.
  $reportJobId = 'INSERT_REPORT_JOB_ID_HERE';

  // Set the format of the report.  Ex: CSV_DUMP
  $exportFormat = 'INSERT_EXPORT_FORMAT_HERE';

  // Set the file name to download the gzipped report to. Ex: report.csv.gz.
  $fileName = 'INSERT_FILE_NAME_HERE' . '.gz';

  $filePath = dirname(__FILE__) . '/' . $fileName;

  $downloadUrl =
      $reportService->getReportDownloadURL($reportJobId, $exportFormat);

  printf("Downloading report from URL '%s'.\n", $downloadUrl);

  ReportUtils::DownloadReport($downloadUrl, $filePath);

  printf("Report downloaded to file '%s'.\n", $filePath);
} catch (OAuth2Exception $e) {
  ExampleUtils::CheckForOAuth2Errors($e);
} catch (ValidationException $e) {
  ExampleUtils::CheckForOAuth2Errors($e);
} catch (Exception $e) {
  print $e->getMessage() . "\n";
}

