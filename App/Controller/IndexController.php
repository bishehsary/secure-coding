<?php

namespace App\Controller;

use App\Model\Heading;
use FW\App\Controller;

class IndexController extends Controller
{

    function indexAction()
    {
        $chapters = Heading::find(['parent' => 0]);
        $grands = [];
        foreach ($chapters as $index => $chapter) {
            $children = Heading::find(['parent' => $chapter['id']]);
            $chapter['children'] = [];
            foreach ($children as $child) {
                $chapter['children'][] = $child;
            }
            $grands[] = $chapter;
        }
        $this->view->set('headings', $grands);
        $this->view->html($this->view->render('headings'));
    }

    function init()
    {
        $headings = [
            "1" => "Header Security (DEV522.3, DEV522.6, DEV541.1, DEV544.1)",
            "1.1" => "X-XSS-Protection",
            "1.2" => "Secure Flag",
            "1.3" => "Http Only Flag",
//            "1.4" => "ASP.NET Header",
            "1.5" => "PHP Header",
            "1.6" => "MVC Header",
            "1.7" => "Server Header",
            "1.8" => "X-Content-Type",
            "2" => "Authentication (DEV522.1, DEV541.2, DEV544.2)",
            "2.1" => "Authentication Scenarios",
            "2.2" => "Implementing form authentication",
            "2.3" => "Password Control",
            "2.4" => "CAPTCHA Mechanism",
            "2.5" => "Mitigating brute force attacks",
            "2.6" => "Authentication Protocols (OAuth, OpenId, SAML, FIDO)",
            "3" => "Authorization (DEV522.1, DEV541.3, DEV544.3)",
            "3.1" => "Authorization models",
            "3.2" => "URL authorization",
            "3.3" => "File authorization",
            "3.4" => "Role Based Access Control (RBAC)",
            "3.5" => "Discretionary Access Control (DAC)",
            "3.6" => "Mandatory Access Control (MAC)",
            "3.7" => "Permission Based Access Control",
            "3.8" => "Working with identities",
            "3.9" => "Claim based authorization",
            "3.10" => "Role manager",
            "3.11" => "MVC Authorization",
            "4" => "Session Management (DEV541.2, DEV544.2)",
            "4.1" => "Session management techniques",
//            "4.2" => "Session state options in .NET",
            "4.3" => "Avoiding session hijacking",
            "4.4" => "Cookie based session management",
            "4.5" => "Cookie information leakage",
            "4.6" => "Cookie Attribute",
            "4.7" => "Session Expiration",
            "4.8" => "Session management common vulnerabilities",
            "5" => "Input Validation (DEV541.1, DEV544.1)",
            "5.1" => "Data Validation Strategies",
            "5.2" => "Sanitize with Whitelist",
            "5.3" => "Sanitize with Blacklist",
            "5.4" => "Implement Validator",
            "6" => "Output Encoding (DEV541.1, DEV544.1)",
            "6.1" => "Preventing HTML injection",
            "6.2" => "Preventing Cross Site Scripting (XSS)",
//            "6.3" => "ASP.NET MVC HTML Encoding",
//            "6.4" => "ASP.NET MVC Request Validator",
            "7" => "Browser Manipulation (DEV541.1, DEV544.1)",
            "7.1" => "Cross Site Request Forgery (CSRF)",
            "7.2" => "Anti CSRF token",
            "7.3" => "CSRF Protection for XHR",
            "7.4" => "Preventing Open Redirection",
            "7.5" => "Preventing ClickJacking",
            "8" => "File Handling",
            "8.1" => "Virtual path mapping",
            "8.2" => "Sanitizing file names",
            "8.3" => "File extension handling",
            "8.4" => "Directory listing",
            "9" => "Cryptography (DEV522.2, DEV541.3, DEV544.3)",
            "9.1" => "Symmetric Encryption",
            "9.2" => "Asymmetric Encryption",
            "9.3" => "Hashing",
            "10" => "AJAX and Web Services Security (DEV522.4)",
            "10.1" => "Web services overview",
            "10.2" => "Security in parsing of XML",
            "10.3" => "XML security",
            "10.4" => "AJAX technologies overview",
            "10.5" => "AJAX attack trends and common attacks",
            "10.6" => "AJAX defense",
            "11" => "Error Handling (DEV541.3, DEV544.3)",
            "11.1" => "Structured exception handling – Try, Catch, Finally",
            "11.2" => "Creating custom error pages",
            "11.3" => "HTTP error codes",
            "11.4" => "Error handling strategies",
            "12" => "Auditing & Logging (DEV541.3, DEV544.3)",
            "12.1" => "Event message structure",
            "12.2" => "Logging best practices",

        ];
        $data = [];
        // parents
        foreach ($headings as $key => $heading) {
            $h = new Heading();
            $h->title = $heading;
            $h->parent = 0;
            if (strpos($key, '.') === false) {
                $id = $h->save();
                $data[$key] = $id;
            }
        }
        // children
        foreach ($headings as $key => $heading) {
            $h = new Heading();
            $h->title = $heading;
            $parts = explode('.', trim($key));
            if (count($parts) == 1) continue;
            $h->parent = $data[$parts[0]];
            $id = $h->save();
            $data[$key] = $id;
        }
    }

    function infoAction()
    {
        phpinfo();
    }

    function genAction()
    {
        return;
        $chapters = Heading::find(['parent' => 0]);
        foreach ($chapters as $chapter) {
            $children = Heading::find(['parent' => $chapter['id']]);
            foreach ($children as $child) {
                $this->genCodes($chapter['id'], $child['id']);
            }
        }
    }

    function updateAction()
    {
        return;
        $chapters = Heading::find(['parent' => 0]);
        foreach ($chapters as $chapter) {
            $chapterFile = __DIR__ . "/Chapter{$chapter['id']}Controller.php";
            $children = Heading::find(['parent' => $chapter['id']]);
            $code = file_get_contents($chapterFile);
            foreach ($children as $child) {
                $methodCode = "protected function code{$child['id']}()";
                $code = str_replace($methodCode, "{$methodCode}// ${child['title']}", $code);
            }
            file_put_contents($chapterFile, $code);
        }
    }

    function readmeAction()
    {
        $chapters = Heading::find(['parent' => 0]);
        $code = '';
        foreach ($chapters as $index => $chapter) {
            $code .= "{$index} {$chapter['title']}" . PHP_EOL;
            $children = Heading::find(['parent' => $chapter['id']]);
            foreach ($children as $child) {
                $code .= "\t- {$child['title']}" . PHP_EOL;
            }
        }
        $this->view->text($code);
    }

    function genCodes($chapter, $code)
    {
        $controllerPath = __DIR__ . "/Chapter{$chapter}Controller.php";
        if (!file_exists($controllerPath)) {
            $controllerCode = <<<EOT
<?php

namespace App\Controller;

class Chapter{$chapter}Controller extends Chapter
{
}
EOT;
            file_put_contents($controllerPath, $controllerCode);
        } else {
            $controllerCode = file_get_contents($controllerPath);
        }

        $tplName = "code{$code}";
        if (strpos($controllerCode, "protected function {$tplName}()") === false) {
            $actionCode = <<<EOT
    protected function {$tplName}()
    {
        \$this->getCode(__FILE__, '{$tplName}');
        //<${tplName}>
        //</${tplName}>
        \$html = \$this->view->render('sample/${tplName}');
        \$this->view->set('result', \$html);
    }
EOT;
            $controllerCode = preg_replace("/}[^}]*$/", $actionCode . PHP_EOL . '}', $controllerCode);
            file_put_contents($controllerPath, $controllerCode);
        }
        $tplPath = __DIR__ . "/../View/templates/sample/{$tplName}.phtml";
        if (!file_exists($tplPath)) {
            $tplCode = <<<EOT
<div class="page">
    <h1>{$tplName}</h1>
</div>
EOT;
            file_put_contents($tplPath, $tplCode);
        }
    }
}