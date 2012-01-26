# bash completion for CakePHP console

_cake()
{
    local cur prev opts cake
    COMPREPLY=()
    cake="${COMP_WORDS[0]}"
	cur="${COMP_WORDS[COMP_CWORD]}"
	prev="${COMP_WORDS[COMP_CWORD-1]}"

	if [[ "$cur" == -* ]] ; then
		if [[ ${COMP_CWORD} = 1 ]] ; then
			opts=$(${cake} BashCompletion.BashCompletion options)
		elif [[ ${COMP_CWORD} = 2 ]] ; then
			opts=$(${cake} BashCompletion.BashCompletion options "${COMP_WORDS[1]}")
		else
			opts=$(${cake} BashCompletion.BashCompletion options "${COMP_WORDS[1]}" "${COMP_WORDS[2]}")
		fi

		COMPREPLY=( $(compgen -W "${opts}" -- ${cur}) )
		return 0
	fi

	if [[ ${COMP_CWORD} = 1 ]] ; then
		opts=$(${cake} BashCompletion.BashCompletion commands)
		COMPREPLY=( $(compgen -W "${opts}" -- ${cur}) )
		return 0
	fi

	if [[ ${COMP_CWORD} = 2 ]] ; then
		opts=$(${cake} BashCompletion.BashCompletion subcommands $prev)
		COMPREPLY=( $(compgen -W "${opts}" -- ${cur}) )
		return 0
	fi


    opts=$(${cake} BashCompletion.BashCompletion fuzzy "${COMP_WORDS[@]:1}")
    COMPREPLY=( $(compgen -W "${opts}" -- ${cur}) )
	return 0;

}
complete -F _cake cake cakephp
