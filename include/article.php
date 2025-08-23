<?php
require_once dirname(__FILE__) ."/utils.php";

/**
 * The class representing an article.
 */
class Article {
    /**
     * Path to the Markdown file.
     * @var string
     */
    private string $filepath;

    /**
     * Contents of the article. Loaded lazily.
     * @var string
     */
    private string $contents;

    /**
     * Rendered HTML elements of the article. Loaded lazily.
     * @var string
     */
    private string $rendered;

    /**
     * Name of the article, stored as the first H1 in the Markdown. Loaded lazily.
     * @var string
     */
    private string $article_name;

    /**
     * Initialize an article with path to the Markdown file.
     * @param string $filepath Path to the Markdown file.
     */
    public function __construct(string $filepath) {
        $this->filepath = $filepath;
    }

    /**
     * Initialize an article with indicated slug and language.
     * @param string $slug Article slug.
     * @param string $lang Language of the article. Defaults to the current language.
     * @return Article The newly initialized article object.
     */
    public static function article(string $slug, string $lang = null): Article {
        if (empty($lang))
            $lang = get_current_language();

        return new Article(dirname(__FILE__) . "/../articles/$lang/$slug.md");
    }

    /**
     * Enumerate all articles of a given language.
     * @param string $lang Language of the article. Defaults to the current language.
     * @throws \Exception In the case we can't enumerate the article directory, we throw an exception.
     * @return array Array of Article objects for the language.
     */
    public static function articles(string $lang = null): array {
        if (empty($lang))
            $lang = get_current_language();

        $articlesdir = dirname(__FILE__) . "/../articles/$lang";
        if (!is_dir($articlesdir))
            if (!mkdir($articlesdir, 0777, true))
                throw new Exception("$articlesdir or its parent is not a directory, nor can I create one.");
    
        $articles = array();
        foreach (glob("$articlesdir/*.md") as $filepath)
            $articles[] = new self($filepath);

        usort($articles, function(Article $a, Article $b) {
            return $a->get_ctime() < $b->get_ctime();
        });

        return $articles;
    }

    public function get_filepath(): string {
        return $this->filepath;
    }

    public function set_filepath(string $filepath): void {
        $this->filepath = $filepath;
    }

    public function get_slug(): string {
        return basename($this->filepath, '.md');
    }

    public function set_slug(string $slug): void {
        $this->filepath = dirname($this->filepath) . '/' . $slug . '.md';
    }

    public function get_ctime(): int|false {
        if (!is_file($this->filepath))
            return false;
        return filectime($this->filepath);
    }

    public function get_mtime(): int|false {
        if (!is_file($this->filepath))
            return false;
        return filemtime($this->filepath);
    }

    public function get_contents(): string {
        if (empty($this->contents))
            $this->contents = file_get_contents($this->filepath);
        return $this->contents;
    }

    public function set_contents(string $contents): void {
        $this->contents = $contents;
        unset($this->rendered);
        unset($this->article_name);
    }

    public function render(): string {
        if (empty($this->rendered)) {
            // TODO: Render the Markdown
        }
        return $this->rendered;
    }

    public function get_article_name(): string {
        if (empty($this->article_name)) {
            $h1s = preg_grep('/^#\s.*$/', explode('\n', $this->get_contents()));
            if (!empty($h1s)) {
                $h1 = reset($h1s);
                $h1pcs = array();
                preg_match('/^#\s+(.*)$/', $h1, $h1pcs);
                reset($h1pcs);
                $this->article_name = next($h1pcs);
            } else {
                $this->article_name = $this->get_slug();
            }
        }
        return $this->article_name;
    }
}