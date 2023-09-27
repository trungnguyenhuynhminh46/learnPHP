<?php
declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;

class View {
    public function __construct(
        protected string $view,
        protected array $params = []
    ){}
    public static function make(string $view, array $params = []) {
        return new static($view, $params);
    }

    public function __toString() {
        $viewPath = VIEWS_DIR . '/' . $this->view . '.php';
        if(!file_exists($viewPath)) {
            throw new ViewNotFoundException($this->view);
        }
        foreach($this->params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }
}
?>