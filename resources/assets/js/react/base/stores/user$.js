import {ReplaySubject} from "rxjs";

const user$ = new ReplaySubject(1);

export default user$;