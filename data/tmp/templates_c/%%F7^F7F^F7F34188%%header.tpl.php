<?php /* Smarty version 2.6.18, created on 2014-04-21 13:34:55
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'header.tpl', 25, false),)), $this); ?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <title>Title</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    </head>
    <body>
        <div>
            <a href="/">Home</a>
            <?php if ($this->_tpl_vars['authenticated']): ?>
                | <a href="/account">Your Account</a>
                | <a href="/account/details">Update Your Details</a>
                | <a href="/account/logout">Logout</a>
            <?php else: ?>
                | <a href="/account/register">Register</a>
                | <a href="/account">Log In</a>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['authenticated']): ?>
                <hr />
                <div>
                    Logged in as
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['identity']->first_name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['identity']->last_name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                    (<a href="/account/logout">logout</a>)
                </div>
            <?php endif; ?>

            <hr />