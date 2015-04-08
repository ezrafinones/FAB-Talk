<?php
class ThreadController extends AppController
{
    public function index()
    {
        $page = Param::get('page', 1);
        $per_page = Thread::MAX_PAGE_SIZE;
        $pagination = new SimplePagination($page, $per_page);

        $threads = Thread::getAll($pagination->start_index - 1, $pagination->count + 1);
        $pagination->checkLastPage($threads);
        $total = Thread::countAll();
        $pages = ceil($total / $per_page);

        $this->set(get_defined_vars());
        if (!Session::get('username')) {
            redirect(url('user/login'));
        }
    }

    public function view()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $thread_id = Param::get('thread_id');

        $per_page = Thread::MAX_PAGE_SIZE;
        $page = Param::get('page', 1);
        $pagination = new SimplePagination($page, $per_page);
        $comments = Comment::getCommentsById($pagination->start_index - 1, $pagination->count + 1, $thread_id);
        $pagination->checkLastPage($comments);
        $total = Comment::count($thread_id);
        $pages = ceil($total / $per_page);
        $this->set(get_defined_vars());
    }

    public function write()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment;
        $page = Param::get('page_next');
            
        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->body = Param::get('body');
                try{
                    $thread->write($comment, Session::get('username'), Session::get('id'));
                } catch(ValidationException $e) {
                    $page = 'write';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function create()
    {
        $thread = new Thread;
        $comment = new Comment;
        $page = Param::get('page_next', 'create');
        $user_id = Session::get('id');

        switch ($page) {
            case 'create':
                break;
            case 'create_end':
                $thread->title = Param::get('title');
                $thread->user_id = $user_id;
                $comment->username = Param::get('username');
                $comment->body = Param::get('body');
                try {
                    $thread->create($comment, Session::get('username'), Session::get('id'));
                } catch (ValidationException $e) {
                    $page = 'create';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function edit()
    {
        $thread = new Thread;
        $page = Param::get('page_next', 'edit');
        $thread_id = Param::get('id');
        $threads = Thread::getThread($thread_id);
        $error = false;

        switch ($page) {
            case 'edit':
                break;
            case 'write_thread':
                $thread->title = Param::get('title');
                try {
                    $thread->edit($thread_id);
                } catch (RecordNotFoundException $e) {
                        $page = 'edit';
                        $error = true;
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function delete()
    {
        $thread_id = Param::get('id');
        $threads = Thread::getThread($thread_id);

        $this->set(get_defined_vars());
    }

    public function confirm_delete()
    {
        $thread_id = Param::get('id');
        $threads = Thread::getThread($thread_id);

        try {
            Thread::delete($thread_id);
        } catch (ValidationException $e) {
            redirect(url('thread/index', array('thread_id' => $thread_id)));
        }
        $this->set(get_defined_vars());
    }

    public function top()
    {
        $favorites = Thread::getMostFavorites();
        $this->set(get_defined_vars());
    }
}
