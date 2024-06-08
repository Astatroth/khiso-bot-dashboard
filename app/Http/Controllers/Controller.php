<?php

namespace App\Http\Controllers;

use App\Services\SeoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var string
     */
    protected string $title;

    /**
     * @var string
     */
    protected string $view;

    /**
     * Ensures that the model exists if ID is not null.
     * Throws NotFoundHttpException, if model with the specified ID does not exist.
     *
     * @param int|null    $id
     * @param Model|null $entity
     */
    protected function ensureEntityExists(int $id = null, Model $model = null): void
    {
        if (!is_null($id) && is_null($model)) {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @param string $message
     */
    protected function error(string $message): void
    {
        $this->message($message, 'error');
    }

    /**
     * @param string $message
     */
    protected function info(string $message): void
    {
        $this->message($message, 'info');
    }

    /**
     * @param string $message
     * @param string $style
     */
    protected function message(string $message, string $style): void
    {
        $message = [
            'style' => $style,
            'message' => $message
        ];

        if (Session::has('messages')) {
            $messages = Session::get('messages');
            $messages[] = $message;

            Session::flash('messages', $messages);
        } else {
            Session::flash('messages', [$message]);
        }
    }

    /**
     * @param string $route
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirect(string $route): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route($route);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function render(array $data = [])
    {
        $data['title'] = $this->title;
        $data['messages'] = collect(Session::get('messages'));

        return view($this->view)->with($data);
    }

    /**
     * @param string $message
     */
    protected function success(string $message): void
    {
        $this->message($message, 'success');
    }

    /**
     * @param string $title
     */
    protected function title(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $view
     */
    protected function view(string $view): void
    {
        $this->view = $view;
    }

    /**
     * @param string $message
     */
    protected function warning(string $message): void
    {
        $this->message($message, 'warning');
    }
}
