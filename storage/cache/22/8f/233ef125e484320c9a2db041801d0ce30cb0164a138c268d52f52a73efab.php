<?php

/* home.phtml */
class __TwigTemplate_228f233ef125e484320c9a2db041801d0ce30cb0164a138c268d52f52a73efab extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<?php displays('header.phtml'); ?>
<div class=\"container\">
<h1><?php echo \$this->title; ?></h1>
    <div class=\"row\">
        <div class=\"col-md-4\">
            <?php echo \$this->content; ?>
        </div>
        <div class=\"col-md-4\">
            <?php echo \$this->content; ?>
        </div>
        <div class=\"col-md-4\">
            <?php echo \$this->content; ?>
        </div>
    </div>
</div>
<?php displays('footer.phtml'); ?>
";
    }

    public function getTemplateName()
    {
        return "home.phtml";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
